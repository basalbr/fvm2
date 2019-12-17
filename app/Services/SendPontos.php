<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Ponto;
use App\Models\Usuario;
use App\Notifications\PontosSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendPontos
{
    /**
     * @param int $id
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public static function handle($id, $request)
    {
        DB::beginTransaction();
        try {
            $ponto = Auth::user()->pontos()->findOrFail($id);
            /* @var Ponto $ponto */
            $ponto->status = 'informacoes_enviadas';
            $ponto->save();
            foreach ($request->get("informacao") as $id_funcionario => $informacao) {
                foreach ($informacao as $nome => $descricao) {
                    if ($descricao) {
                        $ponto->informacoes()->create(['id_funcionario' => $id_funcionario, 'nome' => $nome, 'descricao' => $descricao]);
                    }
                }
            }
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