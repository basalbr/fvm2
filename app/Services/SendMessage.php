<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Mensagem;
use App\Validation\MensagemValidation;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendMessage
{
    use ValidatesRequests;

    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            $message = Mensagem::create($data);
            DB::commit();
            $html = view('dashboard.components.chat.messages', ['messages' => [$message]])->render();
            $lastMessageId = $message->id;
            return response()->json(['messages' => $html, 'lastMessageId' => $lastMessageId]);
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return response()->json(['Não foi possível enviar a mensagem, por favor tente novamente mais tarde'])->setStatusCode(500);
        }
    }

}