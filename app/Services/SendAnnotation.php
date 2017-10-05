<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anotacao;
use App\Models\Mensagem;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendAnnotation
{
    use ValidatesRequests;

    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            /** @var Mensagem $message */
            $anotacao = Anotacao::create($data);
            $anotacao = collect([$anotacao]);
            $html = view('admin.components.anotacoes.anotacoes', ['anotacoes' => $anotacao])->render();
            DB::commit();
            return response()->json(['anotacao' => $html]);
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return response()->json(['Não foi possível enviar a anotação, por favor tente novamente mais tarde'])->setStatusCode(500);
        }
    }

}