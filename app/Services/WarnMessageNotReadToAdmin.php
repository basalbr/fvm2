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
use App\Notifications\AdminHasUnreadMessages;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;

class WarnMessageNotReadToAdmin implements ShouldQueue
{
    use ValidatesRequests;

    public static function handle(Mensagem $message)
    {
        try {
            Usuario::notifyAdmins(new AdminHasUnreadMessages($message));
        } catch (\Exception $e) {
            Log::info('Mensagem id: '.$message->id);
            Log::critical($e);
            return response()->json(['Não foi possível enviar a mensagem, por favor tente novamente mais tarde'])->setStatusCode(500);
        }
    }

}