<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\Deficiencia;
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

        $funcionario = Auth::user()->funcionarios()->find($idFuncionario);
        $documentos = $funcionario->documentos;
        return view('dashboard.funcionario.documentos.index', compact("funcionario", "documentos"));
    }

    public function validateDocumento(Request $request)
    {
        $this->validate($request, FuncionarioDocumentoValidation::getRules(), [], FuncionarioDocumentoValidation::getNiceNames());
    }
}
