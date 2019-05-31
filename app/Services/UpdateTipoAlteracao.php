<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AlteracaoCampo;
use App\Models\TipoAlteracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTipoAlteracao
{

    public static function handle(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            /* @var TipoAlteracao $alteracao */
            $alteracao = TipoAlteracao::findOrFail($id);
            if ($request->has('deletar')) {
                foreach ($request->get('deletar') as $id) {
                    $alteracao = AlteracaoCampo::findOrFail($id);
                    $alteracao->update(['ativo' => 0]);
                }
            }
            if ($request->has('campos')) {
                foreach ($request->get('campos') as $campo) {
                    $alteracao->campos()->create($campo);
                }
            }
            $alteracao->update($request->all());
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}