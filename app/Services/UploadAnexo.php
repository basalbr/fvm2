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
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemInterface;

class UploadAnexo
{

    public static function handle(Request $request, $disk, $target)
    {
        try {
            $filename = md5(random_bytes(5)) . '.' . $request->file('arquivo')->getClientOriginalExtension();
            $request->file('arquivo')->storeAs($target, $filename, $disk);
            return $filename;
        } catch (\Exception $e) {
                $disk->delete($target.$filename);
            Log::critical($e);
            return false;
        }
    }
}