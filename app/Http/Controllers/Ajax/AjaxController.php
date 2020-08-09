<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Ajax;

use App\Models\Chat;
use App\Models\Cnae;
use App\Models\Config;
use App\Models\Imposto;
use App\Models\Mensagem;
use App\Models\Plano;
use App\Models\Usuario;
use App\Notifications\NewChat;
use App\Services\SendAnnotation;
use App\Services\SendContato;
use App\Services\SendMessage;
use App\Services\UploadChatFile;
use App\Services\UploadFile;
use App\Services\UploadImage;
use App\Services\UploadTempFile;
use App\Validation\AnnotationValidation;
use App\Validation\MensagemValidation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $config = Config::first();
        $valorAberturaServico = $config->valor_abertura_servico;
        $valorAberturaComercio = $config->valor_abertura_comercio;
        $valorAberturaIndustria = $config->valor_abertura_industria;
        $valorAbertura = $config->valor_abertura_empresa;
        return response()->json([
            'planos' => $planos,
            'maxDocsFiscais' => (int)$maxDocsFiscais,
            'maxProLabores' => (int)$maxProLabores,
            'maxPrice' => (float)$maxPrice,
            'minPrice' => (float)$minPrice,
            'maxDocsContabeis' => (int)$maxDocsContabeis,
            'valorAberturaServico' => (float)$valorAberturaServico,
            'valorAberturaComercio' => (float)$valorAberturaComercio,
            'valorAberturaIndustria' => (float)$valorAberturaIndustria,
            'valorAbertura' => (float)$valorAbertura,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->merge(['id_usuario' => Auth::user()->id]);
        $this->validate($request, MensagemValidation::getRules(), [], MensagemValidation::getNiceNames());
        $this->authorizeMessage($request->get('referencia'), $request->get('id_referencia'));
        return SendMessage::handle($request->all());
    }

    public function sendAnnotation(Request $request)
    {
        $request->merge(['id_usuario' => Auth::user()->id]);
        $this->validate($request, AnnotationValidation::getRules(), [], AnnotationValidation::getNiceNames());
        return SendAnnotation::handle($request->all());
    }

    public function authorizeMessage($reference, $referenceId)
    {
        if ($reference = 'apuracao') {
            $q = DB::table($reference)
                ->join('empresa', 'empresa.id', '=', 'apuracao.id_empresa')
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
        $lastMessageId = $request->get('id_ultima_mensagem') ? $request->get('id_ultima_mensagem') : 0;
        /** @var Collection $messages */
        $messages = Mensagem::where('id_referencia', '=', $referenceId)
            ->where('referencia', '=', $reference)
            ->where('id', '>', $lastMessageId)
            ->get();
        if (count($messages)) {
            if ($request->get('from_admin')) {
                $html = view('admin.components.chat.messages', ['messages' => $messages])->render();
            } else {
                $html = view('dashboard.components.chat.messages', ['messages' => $messages])->render();
            }
            $lastMessageId = $messages->last()->id;
            return response()->json(['messages' => $html, 'lastMessageId' => $lastMessageId, 'unreadMessages' => count($messages)]);
        }
        return response()->json(['messages' => null, 'lastMessageId' => null, 'unreadMessages' => 0]);
    }

    public function readMessages(Request $request)
    {
        Mensagem::where('id_referencia', '=', $request->get('id_referencia'))
            ->where('referencia', '=', $request->get('referencia'))
            ->where('from_admin', '=', $request->get('from_admin'))
            ->update(['lida' => 1]);
    }

    public function uploadFile(Request $request)
    {
        $rules = ['arquivo' => 'required|file|max:10240', 'descricao' => 'required|max:191', 'id_referencia' => 'required', 'referencia' => 'required'];
        $niceNames = ['arquivo' => 'Arquivo', 'descricao' => 'Descrição', 'id_referencia' => 'ID de referência', 'referencia' => 'Referência'];
        $this->validate($request, $rules, [], $niceNames);
        if ($anexo = UploadFile::handle($request)) {
            return response()->json([
                'id' => $anexo->id,
                'file' => $anexo->arquivo,
                'filepath' => asset(public_path() . 'storage/anexos/' . $request->get('referencia') . '/' . $request->get('id_referencia') . '/' . $anexo->arquivo),
                'date' => $anexo->created_at->format('d/m/Y'),
                'description' => $anexo->descricao
            ]);
        }
        return response()->json(['Não foi possível enviar o arquivo'])->setStatusCode(500);
    }

    public function uploadTempFile(Request $request)
    {
        $rules = ['arquivo' => 'required|file|max:10240', 'descricao' => 'required|max:191'];
        $niceNames = ['arquivo' => 'Arquivo', 'descricao' => 'Descrição'];
        $this->validate($request, $rules, [], $niceNames);
        if ($anexo = UploadTempFile::handle($request)) {
            return response()->json([
                'file' => $anexo,
                'description' => $request->get('descricao')
            ]);
        }
        return response()->json(['Não foi possível enviar o arquivo'])->setStatusCode(500);
    }

    public function uploadImage(Request $request)
    {
        if ($location = UploadImage::handle($request)) {
            return response()->json(['location' => $location]);
        }
        return response()->json(['Não foi possível enviar o arquivo'])->setStatusCode(500);
    }

    public function uploadChatFile(Request $request)
    {
        $rules = ['arquivo' => 'required|file|max:10240', 'id_referencia' => 'required', 'referencia' => 'required'];
        $niceNames = ['arquivo' => 'Arquivo', 'id_referencia' => 'ID de referência', 'referencia' => 'Referência'];
        $this->validate($request, $rules, [], $niceNames);
        if (!$request->has('from_admin')) {
            $request->merge(['from_admin' => false]);
        }
        if ($anexo = UploadChatFile::handle($request)) {
            if ($request->get('from_admin')) {
                return response()->json(['html' => view('admin.components.anexo.withDownload', ['anexo' => $anexo])->render()]);
            }
            return response()->json(['html' => view('dashboard.components.anexo.withDownload', ['anexo' => $anexo])->render()]);
        }
        return response()->json(['Não foi possível enviar o arquivo'])->setStatusCode(500);
    }

    public function getImpostos()
    {
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

    public function getDetailsImposto(Request $request)
    {
        $instrucoes = Imposto::find($request->get('id'))->instrucoes()->orderBy('ordem', 'asc')->get(['descricao']);
        return response()->json($instrucoes);
    }

    public function validateContato(Request $request)
    {
        $rules = ['nome' => 'required|max:100', 'email' => 'email', 'mensagem' => 'required'];
        $niceNames = ['nome' => 'Nome', 'email' => 'E-mail', 'mensagem' => 'Mensagem'];
        $this->validate($request, $rules, [], $niceNames);
    }

    public function sendContato(Request $request)
    {
        $this->validateContato($request);
        if (SendContato::handle($request)) {
            return response()->json('Obrigado pelo seu contato, em breve iremos responder :)');
        }
    }

    public function registerChat(Request $request)
    {
        try {
            $chat = Chat::create($request->all());
            Usuario::notifyAdmins(new NewChat($chat));
            return response()->json(['id' => $chat->id])->setStatusCode(200);
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return response()->json(['erro' => 'Ocorreu um erro interno'])->setStatusCode(500);
        }
    }

    public function updateChat(Request $request)
    {
        try {
            $chat = Chat::find($request->get('chatId'));
            $mensagens = Mensagem::where('referencia', (new Chat())->getTable())
                ->where('id_referencia', $request->get('chatId'))
                ->where('from_admin', 1)
                ->where('id', '>', $request->get('lastMessageId') ? $request->get('lastMessageId') : 0)
                ->orderBy('created_at', 'desc')
                ->get();

            $lastMessage = Mensagem::where('referencia', (new Chat())->getTable())
                ->where('id_referencia', $request->get('chatId'))->latest()->first();
            if ($lastMessage instanceof Mensagem) {
                $lastMessageId = $lastMessage->id;
            } else {
                $lastMessageId = null;
            }
            $html = view('index.components.message', ['mensagens' => $mensagens])->render();
            return response()->json([
                'html' => $html,
                'lastMessageId' => $lastMessageId,
                'status' => $chat->status
            ]);
        } catch (\Exception $e) {
            Log::critical($e);
            return response()->json(['erro' => 'Ocorreu um erro interno'])->setStatusCode(500);
        }
    }

    public function sendMessageChat(Request $request)
    {
        try {
            DB::beginTransaction();
            $mensagens = [Mensagem::create([
                'id_referencia' => $request->get('id_referencia'),
                'referencia' => (new Chat())->getTable(),
                'mensagem' => $request->get('mensagem'),
                'id_usuario' => null,
                'from_admin' => 0,
                'lida' => 0
            ])];
            DB::commit();
            $html = view('index.components.message', ['mensagens' => $mensagens])->render();
            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return response()->json(['erro' => 'Ocorreu um erro interno'])->setStatusCode(500);
        }
    }

    public function chatCount()
    {
        $total = Chat::count();
        return response()->json(['total' => $total]);
    }

    public function chatNotification()
    {
        $total = Chat::count();
        $ultimoChat = Chat::latest()->first();
        if ($total > 0) {
            $url = route('showChatToAdmin', [$ultimoChat->id]);
            return response()->json(['total' => $total, 'title' => $ultimoChat->nome, 'message' => $ultimoChat->assunto, 'url' => $url]);
        }
        return response()->json(['total' => $total, 'title' => '', 'message' => '', 'url' => '']);
    }

}
