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
use App\Models\Noticia;
use App\Models\Usuario;
use App\Notifications\NewChamado;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Not;

class UpdateNoticia
{

    public static function handle(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            /* @var Noticia $noticia */
            $noticia = Noticia::findOrFail($id);
            if($request->file('nova_capa')){
                $filename = Noticia::storeCapa( $request->file('nova_capa'));
                $request->merge(['capa'=>$filename]);
            }
            $noticia->update($request->all());

            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}