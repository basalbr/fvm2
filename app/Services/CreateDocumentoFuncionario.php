<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\FuncionarioContrato;
use App\Models\FuncionarioDeficiencia;
use App\Models\Usuario;
use App\Notifications\NewFuncionario;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateDocumentoFuncionario
{

    public static function handle(Request $request, $idFuncionario)
    {
        DB::beginTransaction();
        try {
            /** @var Funcionario $funcionario */
            $funcionario = Auth::user()->funcionarios()->find($idFuncionario);
            $documento = $funcionario->documentos()->create($request->all());
            /** @var UploadedFile $file */
            $file = $request->file('documento');
            $filename = md5(random_bytes(5)) . $request->get('nome') .'.'. $file->getClientOriginalExtension();
            $file->storeAs('funcionarios/' . $funcionario->id . '/documentos', $filename, 'public');
            $documento->documento = $filename;
            $documento->save();
            DB::commit();

        } catch (\Exception $e) {
            if (isset($file)) {
                /** @var Funcionario $funcionario */
                /** @var string $filename */
                Storage::disk('public')->getDriver()->delete('funcionarios/' . $funcionario->id . '/documentos/' . $filename);
            }
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}