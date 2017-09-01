<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AlteracaoContratual;
use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\FuncionarioContrato;
use App\Models\FuncionarioDeficiencia;
use App\Models\Usuario;
use App\Notifications\NewAlteracaoContratual;
use App\Notifications\NewFuncionario;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateAlteracaoContratual
{

    public static function handle(Request $request)
    {
        DB::beginTransaction();
        try {
            Auth::user()->funcionarios()->findOrFail($request->get('id_funcionario'));


            /** @var AlteracaoContratual $alteracaoContrato */
            $alteracaoContrato = AlteracaoContratual::create($request->all());

            if ($request->has('horario')) {
                foreach ($request->get('horario') as $dia => $horario) {
                    $horario['dia'] = $dia;
                    $alteracaoContrato->horarios()->create($horario);
                }

            }

            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new NewAlteracaoContratual($alteracaoContrato));
            $alteracaoContrato->save();
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}