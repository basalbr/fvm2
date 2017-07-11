<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Chamado;
use App\Models\Chat;
use App\Models\Config;
use App\Models\TipoChamado;
use App\Services\CreateChamado;
use App\Validation\ChamadoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $chats = Chat::orderBy('created_at', 'desc')->get();
        return view('admin.chat.index', compact('chats'));
    }

    public function view($idChat)
    {
        $chat = Chat::findOrFail($idChat);
        return view('admin.chat.view.index', compact('chat'));
    }

    public function activate($idChat)
    {
        $chat = Chat::findOrFail($idChat);
        $chat->update(['status' => 'ativo']);
        return redirect()->back();
    }

    public function terminate($idChat)
    {
        $chat = Chat::findOrFail($idChat);
        $chat->update(['status' => 'fechado']);
        return redirect()->back();
    }

}
