<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Ponto;
use App\Models\Usuario;
use App\Notifications\PontosSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendPontos
{
    /**
     * @param int $id
     * @return bool
     */
    public static function handle($id)
    {
        DB::beginTransaction();
        try {
            $ponto = Auth::user()->pontos()->findOrFail($id);
            /* @var Ponto $ponto */
            $ponto->status = 'informacoes_enviadas';
            $ponto->save();
            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new PontosSent($ponto));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}