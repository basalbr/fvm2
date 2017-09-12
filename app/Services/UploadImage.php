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

class UploadImage
{

    public static function handle(Request $request)
    {
        try {
            $filename = md5(random_bytes(5)) . '.' . $request->file('file')->getClientOriginalExtension();

            $request->file('file')->storeAs('noticias/' , $filename, 'public');
            return asset(public_path().'storage/noticias/'.$filename);
        } catch (\Exception $e) {
            Log::critical($e);
            return false;
        }
    }
}