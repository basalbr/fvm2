<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AberturaEmpresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\NaturezaJuridica;
use App\Models\RegimeCasamento;
use App\Models\TipoChamado;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\CreateAberturaEmpresa;
use App\Services\CreateChamado;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendMessageToAdmin;
use App\Validation\AberturaEmpresaSocioValidation;
use App\Validation\AberturaEmpresaValidation;
use App\Validation\ChamadoValidation;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

class ChamadoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function new()
    {
        $tiposChamado = TipoChamado::orderBy('descricao')->get();
        return view('dashboard.chamado.new.index', compact("tiposChamado"));
    }

    public function validateChamado(Request $request)
    {
        $this->validate($request, ChamadoValidation::getRules(), [], ChamadoValidation::getNiceNames());
    }

    public function store(Request $request)
    {
        dd($request->all());
        $this->validate($request, ChamadoValidation::getRules(), [], ChamadoValidation::getNiceNames());
        if (CreateChamado::handle($request)) {
            dd('a');
        }
        dd('b');
    }

}
