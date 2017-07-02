<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anexo;
use App\Models\Chamado;
use App\Models\ContratoTrabalho;
use App\Models\Mensagem;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemInterface;

class UploadChatFile
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /** @var Mensagem $mensagem **/
            $mensagem = Mensagem::create([
                'id_usuario' => Auth::user()->id,
                'referencia' => $request->get('referencia'),
                'id_referencia' => $request->get('id_referencia'),
                'mensagem' => 'Enviou o arquivo:',
                'from_admin'=>$request->get('from_admin')
            ]);
            $originalFileName = $request->file('arquivo')->getClientOriginalName();
            $filename = md5(random_bytes(5)) . '.' . $request->file('arquivo')->getClientOriginalExtension();
            /** @var Anexo $anexo **/
            $anexo = Anexo::create([
                'descricao' => $originalFileName,
                'arquivo' => $filename,
                'id_referencia' => $mensagem->id,
                'referencia' => $mensagem->getTable()
            ]);
            //Enviar e-mail avisando q tem uma nova mensagem

            $request->file('arquivo')->storeAs('anexos/' . $mensagem->getTable() . '/' . $mensagem->id . '/', $filename, 'public');
            DB::commit();
            return $anexo;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }
}