<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AlteracaoContratual;
use App\Models\Config;
use App\Models\DecimoTerceiro;
use App\Models\Empresa;
use App\Models\TipoAlteracaoContratual;
use App\Services\CreateDecimoTerceiro;
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
        $decimosTerceiro = Auth::user()->decimosTerceiro;
        return view('dashboard.decimo_terceiro.index', compact('decimosTerceiro'));
    }


    public function view($id)
    {
        $decimoTerceiro =  Auth::user()->decimosTerceiro()->findOrFail($id);
        return view('dashboard.decimo_terceiro.view.index', compact('decimoTerceiro'));
    }

    public function validateDecimoTerceiro(Request $request)
    {
        $this->validate($request, DecimoTerceiroValidation::getRules(), [], DecimoTerceiroValidation::getNiceNames());
    }

}
