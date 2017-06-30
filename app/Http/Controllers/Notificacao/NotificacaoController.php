<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Notificacao;

use App\Models\AberturaEmpresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\NaturezaJuridica;
use App\Models\Notificacao;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\CreateAberturaEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendMessageToAdmin;
use App\Validation\AberturaEmpresaSocioValidation;
use App\Validation\AberturaEmpresaValidation;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ler($idNotificacao)
    {
        /** @var Notificacao $notificacao */
        $notificacao = Auth::user()->notifications()->find($idNotificacao);
        $notificacao->markAsRead();
        return redirect()->to($notificacao->data['url']);
    }


}
