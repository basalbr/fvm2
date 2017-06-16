<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateUsuario
{
    /**
     * @param Request $request
     * @return Usuario|bool
     */
    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            /** @var Usuario $usuario */
            $usuario = Auth::user();
            $usuario->nome = $request->get('nome');
            $usuario->telefone = $request->get('telefone');
            if ($request->get('foto')) {
                Storage::move('temp/' . $request->get('foto'), 'public/usuarios/' . $usuario->id . '/' . $request->get('foto'));
                $usuario->foto = $request->get('foto');
            }
            if ($request->get('senha')) {
                $usuario->senha = $request->get('senha');
            }
            $usuario->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }

        return $usuario;
    }

}