<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ImpostoRenda;
use App\Notifications\FilesAvailableInImpostoRenda;
use App\Notifications\NewStatusImpostoRenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateImpostoRenda
{

    public static function handle(Request $request, int $id)
    {
        DB::beginTransaction();
        try {

            /* @var ImpostoRenda $ir */
            $ir = ImpostoRenda::findOrFail($id);
            $ir->update($request->all());
            $hasFile = false;
            if ($request->get('recibo')) {
                Storage::move('temp/' . $request->get('recibo'), 'public/anexos/imposto_renda/' . $ir->id . '/' . $request->get('recibo'));
                $hasFile = true;
            }
            if ($request->get('declaracao')) {
                Storage::move('temp/' . $request->get('declaracao'), 'public/anexos/imposto_renda/' . $ir->id . '/' . $request->get('declaracao'));
                $hasFile = true;
            }
            if($hasFile){
                $ir->usuario->notify(new FilesAvailableInImpostoRenda($ir));
            }
            $ir->usuario->notify(new NewStatusImpostoRenda($ir));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}