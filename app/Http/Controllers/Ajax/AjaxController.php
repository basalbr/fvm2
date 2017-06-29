<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Ajax;

use App\Models\Cnae;
use App\Models\Imposto;
use App\Models\Mensagem;
use App\Models\Plano;
use App\Services\SendMessage;
use App\Services\UploadChatFile;
use App\Validation\MensagemValidation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Buscar um CNAE através do código
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCnaeByCode(Request $request)
    {
        $rules = ['code' => 'required'];
        $this->validate($request, $rules, [], ['code' => 'Código']);
        try {
            $cnae = Cnae::where('codigo', '=', $request->get('code'))->select('codigo', 'descricao', 'id_tabela_simples_nacional')->firstOrFail();
            /** @var Cnae $cnae */
            if ($cnae->isSimplesNacional()) {
                return response()->json($cnae, 200);
            }
            return response()->json(['message' => 'Este CNAE não é do simples nacional'], 403)->setStatusCode(403);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'CNAE não encontrado'], 404)->setStatusCode(404);
        }
    }

    /**
     * Buscar um CNAE através da descrição
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function searchCnaeByDescription(Request $request)
    {
        $rules = ['description' => 'required'];
        $this->validate($request, $rules, []);
        $cnaes = Cnae::where('descricao', 'like', '%' . $request->get('description') . '%')->select('codigo', 'descricao')->limit(5)->get();
        if ($cnaes->count()) {
            return response()->json($cnaes, 200);
        }
        return response()->json(['message' => 'Nenhum CNAE encontrado'], 404);
    }

    public function getMonthlyPaymentParams()
    {
        $planos = Plano::orderBy('total_documento_fiscal', 'asc')->get(['total_documento_fiscal', 'total_documento_contabil', 'total_pro_labore', 'valor']);
        $maxDocsFiscais = Plano::max('total_documento_fiscal');
        $maxDocsContabeis = Plano::max('total_documento_contabil');
        $maxProLabores = Plano::max('total_pro_labore');
        $maxPrice = Plano::max('valor');
        $minPrice = Plano::min('valor');
        return response()->json([
            'planos' => $planos,
            'maxDocsFiscais' => (int)$maxDocsFiscais,
            'maxProLabores' => (int)$maxProLabores,
            'maxPrice' => (float)$maxPrice,
            'minPrice' => (int)$minPrice,
            'maxDocsContabeis' => (int)$maxDocsContabeis
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->merge(['id_usuario' => Auth::user()->id]);
        $this->validate($request, MensagemValidation::getRules(), [], MensagemValidation::getNiceNames());
        $this->authorizeMessage($request->get('referencia'), $request->get('id_referencia'));
        return SendMessage::handle($request->all());
    }

    public function authorizeMessage($reference, $referenceId)
    {
        if ($reference = 'apuracao') {
            $q = DB::table($reference)
                ->join('empresa','empresa.id','=','apuracao.id_empresa')
                ->where('apuracao.id', '=', $referenceId)
                ->where('empresa.id_usuario', '=', Auth::user()->id)->count();
        } else {
            $q = DB::table($reference)->where('id', '=', $referenceId)->where('id_usuario', '=', Auth::user()->id)->count();
        }
        if ($q > 0) {
            return true;
        }
        return response()->json(['Você não está autorizado para enviar essa mensagem'])->setStatusCode(403);
    }

    public function updateMessages(Request $request)
    {
        $referenceId = $request->get('id_referencia');
        $reference = $request->get('referencia');
        $lastMessageId = $request->get('id_ultima_mensagem');

        /** @var Collection $messages */
        $messages = Mensagem::where('id_referencia', '=', $referenceId)
            ->where('referencia', '=', $reference)
            ->where('id', '>', $lastMessageId)
            ->get();

        if (count($messages)) {
            $html = view('dashboard.components.chat.messages', ['messages' => $messages])->render();
            $lastMessageId = $messages->last()->id;
            return response()->json(['messages' => $html, 'lastMessageId' => $lastMessageId]);
        }
        return response()->json(['messages' => null, 'lastMessageId' => null]);
    }

    public function uploadChatFile(Request $request)
    {
        $rules = ['arquivo' => 'required|file|max:10240', 'id_referencia' => 'required', 'referencia' => 'required'];
        $niceNames = ['arquivo' => 'Arquivo', 'id_referencia' => 'ID de referência', 'referencia' => 'Referência'];
        $this->validate($request, $rules, [], $niceNames);
        if ($anexo = UploadChatFile::handle($request)) {
            return response()->json(['html' => view('dashboard.components.anexo.withDownload', ['anexo' => $anexo])->render()]);
        }
        return response()->json(['Não foi possível enviar o arquivo'])->setStatusCode(500);
    }

    public function getImpostos(){
        $impostos = Imposto::all();
        $jsonRet = array();
        if ($impostos->count()) {
            foreach ($impostos as $imposto) {
                if ($imposto->meses->count()) {
                    foreach ($imposto->meses as $impostoMes) {
                        $mes = $impostoMes->mes + 1;
                        $date = $imposto->corrigeData(date('Y') . '-' . $mes . '-' . $imposto->vencimento, 'c');
                        $jsonRet[] = array('title' => $imposto->nome, 'start' => $date, 'id' => $imposto->id);
                    }
                }
            }
        }
        return response()->json($jsonRet);
    }

    public function getDetailsImposto(Request $request){
        $instrucoes = Imposto::find($request->get('id'))->instrucoes()->orderBy('ordem', 'asc')->get(['descricao']);
        return response()->json($instrucoes);
    }

}
