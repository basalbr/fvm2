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
use App\Notifications\MensalidadeAdjustment;
use App\Notifications\MessageSent;
use App\Validation\MensagemValidation;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendMendalidadeAdjustment
{
    use ValidatesRequests;

    public static function handle($usuarios)
    {
        try {
            foreach($usuarios as $usuario){
                $usuario->notify(new MensalidadeAdjustment($usuario));
            }
        } catch (\Exception $e) {
            Log::critical($e);
        }
    }

}