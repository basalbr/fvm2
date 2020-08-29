<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Anotacao;
use App\Models\Apuracao;
use App\Models\Empresa;
use App\Models\FaixaSimplesNacional;
use App\Models\HistoricoFaturamento;
use App\Models\ImpostoFaixaSimplesNacional;
use App\Models\Mensagem;
use App\Models\RegistroAtividade;
use App\Models\Tributacao;
use App\Models\TributacaoIsencao;
use App\Services\UpdateApuracao;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class ApuracaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($idApuracao)
    {
        /* @var Apuracao $apuracao */
        $apuracao = Apuracao::find($idApuracao);
        $qtdeDocumentos = $apuracao->informacoes()
            ->join('imposto_informacao_extra', 'imposto_informacao_extra.id', 'apuracao_informacao_extra.id_informacao_extra')
            ->where('imposto_informacao_extra.tipo', 'anexo')
            ->count();
        $qtdeDocumentos += Mensagem::join('anexo', 'anexo.id_referencia', 'mensagem.id')
            ->where('anexo.referencia', 'mensagem')
            ->where('mensagem.referencia', 'apuracao')
            ->where('mensagem.id_referencia', $idApuracao)
            ->count();
        $qtdeDocumentos += $apuracao->anexos()->count();
        $observacoes = Anotacao::where('referencia', 'observacao_apuracao')->where('id_referencia', $apuracao->id_empresa)->get();
        $qtdeObservacoes = count($observacoes);
        return view('admin.apuracao.view.index', compact('apuracao', 'qtdeDocumentos', 'observacoes', 'qtdeObservacoes'));
    }

    public function index(Request $request)
    {
        $apuracoesPendentes = Apuracao::query()->whereIn('apuracao.status', ['informacoes_enviadas', 'novo', 'atencao']);
        if (!$request->has('tab') || $request->get('tab') == 'pendentes') {
            $apuracoesPendentes = $this->filterForm($apuracoesPendentes, $request);
        }
        $qtdApuracoes = $apuracoesPendentes->select('apuracao.*')->count();
        $apuracoesPendentes = $apuracoesPendentes->select('apuracao.*')->paginate(10);


        $apuracoesConcluidas = Apuracao::query()->whereNotIn('apuracao.status', ['informacoes_enviadas', 'novo', 'atencao']);
        if (!$request->has('tab') || $request->get('tab') == 'historico') {
            $apuracoesConcluidas = $this->filterForm($apuracoesConcluidas, $request);
        }
        $apuracoesConcluidas = $apuracoesConcluidas->select('apuracao.*')->paginate(10);

        return view('admin.apuracao.index', compact('apuracoesConcluidas', 'apuracoesPendentes', 'qtdApuracoes'));
    }

    public function validateGuia(Request $request)
    {
        $rules = ['arquivo' => 'max:10240|required|file|mimes:pdf'];
        $niceNames = ['arquivo' => 'Guia'];
        $this->validate($request, $rules, [], $niceNames);
    }

    public function update(Request $request, $idApuracao)
    {
        if (UpdateApuracao::handle($request, $idApuracao)) {
            return redirect()->route('showApuracaoToAdmin', [$idApuracao])->with('successAlert', 'Apuração atualizada com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function filterForm($query, $request)
    {
        $query->join('empresa', 'empresa.id', '=', 'apuracao.id_empresa')->join('usuario', 'usuario.id', '=', 'empresa.id_usuario');
        if ($request->get('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('usuario.nome', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.telefone', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('usuario.email', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.nome_fantasia', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.razao_social', 'LIKE', '%' . $request->get('busca') . '%')
                    ->orWhere('empresa.cnpj', 'LIKE', '%' . $request->get('busca') . '%');
            });
        }
        if ($request->get('imposto')) {
            $query->where('apuracao.id_imposto', $request->get('imposto'));
        }
        if ($request->get('status')) {
            $query->where('apuracao.status', $request->get('status'));
        }
        if ($request->get('de')) {
            $data = explode('/', $request->get('de'));
            $query->where('apuracao.competencia', '>=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ate')) {
            $data = explode('/', $request->get('ate'));
            $query->where('apuracao.competencia', '<=', $data[2] . '-' . $data[1] . '-' . $data[0]);
        }
        if ($request->get('ordenar')) {
            switch ($request->get('ordenar')) {
                case 'periodo_asc':
                    $query->orderBy('apuracao.competencia');
                    break;
                case 'periodo_desc':
                    $query->orderBy('apuracao.competencia', 'desc');
                    break;
                case 'empresa_asc':
                    $query->orderBy('empresa.nome');
                    break;
                case 'empresa_desc':
                    $query->orderBy('empresa.nome', 'desc');
                    break;
                case 'razao_social_asc':
                    $query->orderBy('empresa.razao_social');
                    break;
                case 'razao_social_desc':
                    $query->orderBy('empresa.razao_social', 'desc');
                    break;
                default:
                    $query->orderBy('apuracao.competencia');
            }
        } else {
            $query->orderBy('apuracao.competencia', 'desc')->orderBy('status', 'desc');
        }
        return $query;
    }

    public function downloadZip($apuracaoId)
    {
        $cont = 0;
        $apuracao = Apuracao::findOrFail($apuracaoId);
        $files = array();
        # create new zip object
        $zip = new ZipArchive();
        # create a temp file & open it
        $tmp_file = @tempnam('.', '');
        $zip->open($tmp_file, ZipArchive::CREATE);
        foreach ($apuracao->informacoes as $informacao) {
            if ($informacao->tipo->tipo == 'anexo') {
                $download_file = file_get_contents(asset(public_path() . 'storage/anexos/' . $informacao->toAnexo()->referencia . '/' . $informacao->toAnexo()->id_referencia . '/' . $informacao->toAnexo()->arquivo));
                $zip->addFromString($cont . $informacao->tipo->nome, $download_file);
                $cont++;
            }
        }

        foreach ($apuracao->anexos as $anexo) {
            $download_file = file_get_contents(asset(public_path() . 'storage/anexos/' . $anexo->referencia . '/' . $anexo->id_referencia . '/' . $anexo->arquivo));
            $zip->addFromString($cont . str_replace('/', ' ', $anexo->descricao) . '.' . pathinfo($anexo->arquivo, PATHINFO_EXTENSION), $download_file);
            $cont++;
        }
        foreach ($apuracao->mensagens as $message) {
            if ($message->anexo) {
                $download_file = file_get_contents(asset(public_path() . 'storage/anexos/' . $message->anexo->referencia . '/' . $message->anexo->id_referencia . '/' . $message->anexo->arquivo));
                $zip->addFromString($cont . str_replace('/', ' ', $message->anexo->descricao), $download_file);
                $cont++;
            }
        }
        $zip->close();
        # send the file to the browser as a download
        header('Content-disposition: attachment; filename="documentos.zip"');
        header('Content-type: application/zip');
        readfile($tmp_file);
        unlink($tmp_file);
    }

    public function calculateSimplesNacional(Request $request)
    {
        $impostoParaPagar = 0;
        foreach ($request->get('tributacoes') as $tributacao) {
            $tributo = Tributacao::findOrFail($tributacao['id_tributacao']);
            if ($tributo->mercado == 'interno') {
                $rbu12mInterno = $tributo->empresa->getReceitaBrutaUltimosDozeMesesSN($request->get('competencia'), 'interno');
                $faixaSimplesNacional = FaixaSimplesNacional::where('id_tabela_simples_nacional', $tributo->id_tabela_simples_nacional)
                    ->where('de', '<=', $rbu12mInterno)->where('ate', '>=', $rbu12mInterno)->first();
                if ($faixaSimplesNacional->de == 0) {
                    $aliquotaEfetiva = $faixaSimplesNacional->aliquota;
                } else {
                    $aliquotaEfetiva = ((($rbu12mInterno * ($faixaSimplesNacional->aliquota / 100)) - $faixaSimplesNacional->deducao) / $rbu12mInterno) * 100;
                }
            } else {
                $rbu12mExterno = $tributo->empresa->getReceitaBrutaUltimosDozeMesesSN($request->get('competencia'), 'externo');
                $faixaSimplesNacional = FaixaSimplesNacional::where('id_tabela_simples_nacional', $tributo->id_tabela_simples_nacional)
                    ->where('de', '<=', $rbu12mExterno)->where('ate', '>=', $rbu12mExterno)->first();
                if ($faixaSimplesNacional->de == 0) {
                    $aliquotaEfetiva = $faixaSimplesNacional->aliquota;
                } else {
                    $aliquotaEfetiva = ((($rbu12mExterno * ($faixaSimplesNacional->aliquota / 100)) - $faixaSimplesNacional->deducao) / $rbu12mExterno) * 100;
                }
            }

            $impostosFaixaSimplesNacional = ImpostoFaixaSimplesNacional::where('id_faixa_simples_nacional', $faixaSimplesNacional->id)->get(['id'])->toArray();
            $isencoes = 0;
            foreach (TributacaoIsencao::where('id_tributacao', $tributo->id)->whereIn('id_imposto_faixa_simples_nacional', $impostosFaixaSimplesNacional)->get() as $tributacaoIsentacao) {
                $isencoes += $tributacaoIsentacao->imposto->valor;
            }
            if ($isencoes > 0) {
                $aliquotaEfetiva -= $aliquotaEfetiva * ($isencoes / 100);
            }

            $impostoParaPagar += ($tributacao['valor'] * $aliquotaEfetiva) / 100;
        }
        return response()->json(number_format($impostoParaPagar, 2, ',', '.'))->setStatusCode(200);
    }

    public function semMovimento($idApuracao)
    {
        $apuracao = Apuracao::findOrFail($idApuracao);
        HistoricoFaturamento::create(['id_empresa' => $apuracao->id_empresa, 'competencia' => $apuracao->competencia, 'mercado' => 'interno', 'valor' => 0]);
        HistoricoFaturamento::create(['id_empresa' => $apuracao->id_empresa, 'competencia' => $apuracao->competencia, 'mercado' => 'externo', 'valor' => 0]);
        $apuracao->status = 'sem_movimento';
        $apuracao->save();
        RegistroAtividade::create([
            'id_usuario' => Auth::user()->id,
            'id_referencia' => $apuracao->id,
            'referencia' => 'apuracao',
            'mensagem' => Auth::user()->nome . ' informou como sem movimento'
        ]);
        return redirect()->route('showApuracaoToAdmin', [$idApuracao])->with('successAlert', 'Apuração atualizada com sucesso.');
    }

}
