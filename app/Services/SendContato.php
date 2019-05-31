<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Mail\NewContatoFromSite;
use App\Models\Usuario;
use App\Notifications\MessageFromSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContato
{

    public static function handle(Request $request)
    {
        try {
            //Notifica admins que existe um novo funcionario cadastrado
            Mail::to('contato@webcontabilidade.com')->send(new NewContatoFromSite($request));
//            Usuario::notifyAdmins(new MessageFromSite($request));
        } catch (\Exception $e) {
            Log::critical($e);
            return false;
        }
        return true;
    }

}