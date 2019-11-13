<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\DecimoTerceiro;
use App\Models\Empresa;
use App\Services\CreateDecimoTerceiro;
use App\Validation\DecimoTerceiroValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DecimoTerceiroController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $decimosTerceiro = DecimoTerceiro::orderBy("created_at", 'desc')->get();
        return view('admin.decimo_terceiro.index', compact('decimosTerceiro'));
    }


    public function new()
    {
        $empresas = Empresa::whereHas('funcionarios', function ($q) {
            $q->where('status', 'ativo');
        })->where('status', 'aprovado')->orderBy('razao_social')->get();
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
