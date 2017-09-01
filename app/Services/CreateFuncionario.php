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

class CreateFuncionario
{

    public static function handle(Request $request, $idEmpresa)
    {
        DB::beginTransaction();
        try {
            /** @var Empresa $empresa */
            $empresa = Auth::user()->empresas()->find($idEmpresa);

            /** @var Funcionario $funcionario */
            $funcionario = $empresa->funcionarios()->create($request->all());

            if ($request->has('deficiencias')) {
                foreach ($request->get('deficiencias') as $deficiencia) {
                    $deficiencia['id_funcionario'] = $funcionario->id;
                    FuncionarioDeficiencia::create($deficiencia);
                }
            }

            if ($request->has('dependentes')) {
                $funcionario->dependentes()->createMany($request->get('dependentes'));
            }

            /** @var FuncionarioContrato $contrato */

            $contrato = $funcionario->contratos()->create($request->get('contrato'));

            if ($request->has('horario')) {
                foreach ($request->get('horario') as $dia => $horario) {
                    $horario['dia'] = $dia;
                    $contrato->horarios()->create($horario);
                }

            }

            if ($request->hasFile('documentos')) {
                /** @var UploadedFile $file */
                $file = $request->file('documentos')['exame_admissional'];
                $filename =  'exame_admissional' .md5(random_bytes(5)). '.' . $file->getClientOriginalExtension();
                $file->storeAs('anexos/' . 'funcionario' . '/' . $funcionario->id . '/', $filename, 'public');
                $funcionario->anexos()->create(['arquivo' => $filename, 'id_referencia' => $funcionario->id, 'referencia'=>'funcionario', 'descricao' => 'Exame admissional']);
            }
            //Notifica admins que existe um novo funcionario cadastrado
            Usuario::notifyAdmins(new NewFuncionario($funcionario));
            $funcionario->save();
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