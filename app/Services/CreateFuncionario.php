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
use App\Models\Mensalidade;
use App\Models\Usuario;
use App\Notifications\NewEmpresa;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                $funcionario->deficiencias()->create($request->get('deficiencias'));
            }
            if ($request->has('dependentes')) {
                $funcionario->dependentes()->create($request->get('dependentes'));
            }
            /** @var FuncionarioContrato $contrato */

            $contrato = $funcionario->contratos()->create($request->get('contrato'));
            $contrato->horarios()->create($request->get('horario'));

            if ($request->hasFile('documentos')) {
                /** @var UploadedFile $file */
                $file = $request->file('documentos')['exame_admissional'];
                $filename = 'exame_admissional.' . $file->guessClientExtension();
                $file->storeAs('funcionarios/documentos', $filename);
                $funcionario->documentos()->create(['documento' => $filename, 'nome' => 'exame_admissional', 'descricao' => 'Exame admissional do funcionário']);
            }

            //Cadastra Mensalidade
            $data['mensalidade']['qtde_pro_labore'] = $empresa->getQtdeProLabores();
            $data['mensalidade']['id_usuario'] = $empresa->usuario->id;
            $data['mensalidade']['valor'] = Mensalidade::calculateMonthlyPayment($data['mensalidade']);
            $empresa->mensalidades()->create($data['mensalidade']);
            //Notifica admins que existe uma nova  empresa
            Usuario::notifyAdmins(new NewEmpresa($empresa));
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}