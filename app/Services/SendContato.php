<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\FuncionarioContrato;
use App\Models\FuncionarioDeficiencia;
use App\Models\Usuario;
use App\Notifications\MessageFromSite;
use App\Notifications\NewFuncionario;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendContato
{

    public static function handle(Request $request)
    {
        try {
            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new MessageFromSite($request));
        } catch (\Exception $e) {
            Log::critical($e);
            return false;
        }
        return true;
    }
}