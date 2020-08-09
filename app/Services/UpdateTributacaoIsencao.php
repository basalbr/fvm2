<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Empresa;
use App\Models\FaixaSimplesNacional;
use App\Models\HistoricoFaturamento;
use App\Models\ImpostoFaixaSimplesNacional;
use App\Models\RegistroAtividade;
use App\Models\Tributacao;
use App\Models\TributacaoIsencao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTributacaoIsencao
{

    public static function handle(Request $request, $idTributacao)
    {
        DB::beginTransaction();
        try {

            $tributacao = Tributacao::findOrFail($idTributacao);
            if ($request->get('action') == 'remover') {
                $faixasSN = FaixaSimplesNacional::where('id_tabela_simples_nacional', $tributacao->id_tabela_simples_nacional)->get(['id'])->toArray();
                $impostosIsentosSN = ImpostoFaixaSimplesNacional::whereIn('id_faixa_simples_nacional', $faixasSN)->where('descricao', $request->get('imposto'))->get(['id']);
                TributacaoIsencao::where('id_tributacao', $tributacao->id)->whereIn('id_imposto_faixa_simples_nacional', $impostosIsentosSN)->delete();
                RegistroAtividade::create([
                    'id_usuario' => Auth::user()->id,
                    'id_referencia' => $tributacao->id,
                    'referencia' => 'tributacao',
                    'mensagem' => Auth::user()->nome . ' removeu a isenção de ' . $request->get('imposto') . ' da tributação ' . $tributacao->descricao
                ]);
            }
            if ($request->get('action') == 'adicionar') {
                $faixasSN = FaixaSimplesNacional::where('id_tabela_simples_nacional', $tributacao->id_tabela_simples_nacional)->get(['id'])->toArray();
                $impostosIsentosSN = ImpostoFaixaSimplesNacional::whereIn('id_faixa_simples_nacional', $faixasSN)->where('descricao', $request->get('imposto'))->get(['id']);
                foreach ($impostosIsentosSN as $imposto) {
                    TributacaoIsencao::create(['id_tributacao' => $tributacao->id, 'id_imposto_faixa_simples_nacional' => $imposto->id]);
                }
                RegistroAtividade::create([
                    'id_usuario' => Auth::user()->id,
                    'id_referencia' => $tributacao->id,
                    'referencia' => 'tributacao',
                    'mensagem' => Auth::user()->nome . ' adicionou a isenção de ' . $request->get('imposto') . ' na tributação ' . $tributacao->descricao
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }
}