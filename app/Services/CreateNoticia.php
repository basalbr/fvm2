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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CreateNoticia
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {

            $filename = Noticia::storeCapa($request->file('capa'));
            $date = Carbon::createFromFormat('d/m/Y', $request->get('data_publicacao'));
            $request->merge(['slug' => $date->format('Y-m') . '-' . str_slug($request->get('titulo'))]);
            $noticia = Noticia::create($request->all());
            $noticia->capa = $filename;
            $noticia->save();
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}