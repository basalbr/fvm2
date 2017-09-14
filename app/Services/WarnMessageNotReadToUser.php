<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Mensagem;
use App\Models\Usuario;
use App\Notifications\MessageSent;
use App\Notifications\UserHasUnreadMessages;
use App\Validation\MensagemValidation;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WarnMessageNotReadToUser
{
    use ValidatesRequests;

    public static function handle(Mensagem $message)
    {
        DB::beginTransaction();
        try {
            if ($message->referencia == 'funcionario' || $message->referencia == 'apuracao') {
                $usuario = $message->parent->empresa->usuario;
            }else{
                $usuario = $message->parent->usuario;
            }
            if($usuario instanceof Usuario){
            $usuario->notify(new UserHasUnreadMessages($message));
            }
        } catch (\Exception $e) {
            Log::critical($e);
            return response()->json(['Não foi possível enviar a mensagem, por favor tente novamente mais tarde'])->setStatusCode(500);
        }
    }

}