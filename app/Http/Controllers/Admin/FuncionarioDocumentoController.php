<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Deficiencia;
use App\Models\Funcionario;
use App\Services\CreateDocumentoFuncionario;
use App\Validation\FuncionarioDocumentoValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FuncionarioDocumentoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index($idEmpresa, $idFuncionario)
    {

        $funcionario = Funcionario::findOrFail($idFuncionario);
        $documentos = $funcionario->documentos()->orderBy('created_at', 'desc')->get();
        return view('admin.funcionario.documentos.index', compact("funcionario", "documentos"));
    }

    public function validateDocumento(Request $request)
    {
        $this->validate($request, FuncionarioDocumentoValidation::getRules(), [], FuncionarioDocumentoValidation::getNiceNames());
    }

    public function store(Request $request, $idEmpresa, $idFuncionario){
        $this->validate($request, FuncionarioDocumentoValidation::getRules(), [], FuncionarioDocumentoValidation::getNiceNames());
        if (CreateDocumentoFuncionario::handle($request, $idFuncionario)) {
            return redirect()->route('listDocumentosFuncionarioToUser', [$idEmpresa, $idFuncionario])->with('successAlert', 'Documento enviado com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }
}
