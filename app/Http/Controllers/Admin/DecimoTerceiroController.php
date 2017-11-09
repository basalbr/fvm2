<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\AlteracaoContratual;
use App\Models\Config;
use App\Models\DecimoTerceiro;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\TipoAlteracaoContratual;
use App\Services\CreateAlteracaoContratual;
use App\Services\CreateDecimoTerceiro;
use App\Services\SendPontos;
use App\Validation\AlteracaoContratualValidation;
use App\Validation\DecimoTerceiroValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DecimoTerceiroController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $decimosTerceiro = DecimoTerceiro::all();
        return view('admin.decimo_terceiro.index', compact('decimosTerceiro'));
    }


    public function new()
    {
        $empresas = Empresa::orderBy('razao_social')->get();
        return view('admin.decimo_terceiro.new.index', compact('empresas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, DecimoTerceiroValidation::getRules(), [], DecimoTerceiroValidation::getNiceNames());
        if (CreateDecimoTerceiro::handle($request)) {

            return redirect()->route('listDecimoTerceiroToAdmin')->with('successAlert', 'Documentos enviados com sucesso.');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function view($id)
    {
        $decimoTerceiro = DecimoTerceiro::findOrFail($id);
        return view('admin.decimo_terceiro.view.index', compact('decimoTerceiro'));
    }

    public function validateDecimoTerceiro(Request $request)
    {
        $this->validate($request, DecimoTerceiroValidation::getRules(), [], DecimoTerceiroValidation::getNiceNames());
    }

}
