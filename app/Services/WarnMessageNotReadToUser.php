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
use App\Notifications\UserHasUnreadMessages;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;

class WarnMessageNotReadToUser implements ShouldQueue
{
    use ValidatesRequests;

    public static function handle(Mensagem $message)
    {
        try {
            $usuario = $message->targetUser();
            if ($usuario instanceof Usuario) {
                $usuario->notify(new UserHasUnreadMessages($message));
            }
        } catch (\Exception $e) {
            Log::critical($e);
        }
    }

}