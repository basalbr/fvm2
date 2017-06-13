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
use App\Services\UploadAnexo;
use App\Validation\AberturaEmpresaSocioValidation;
use App\Validation\AberturaEmpresaValidation;
use App\Validation\AnexoValidation;
use App\Validation\ChamadoValidation;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnexoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendToTemp(Request $request)
    {
        $this->validate($request, AnexoValidation::getRules(), [], AnexoValidation::getNiceNames());
        if ($filename = UploadAnexo::handle($request, Storage::disk('local')->getDriver(), 'temp/')) {
            return response()->json(['filename'=>$filename]);
        }
        return response()->setStatusCode(500)->json(['Não foi possível fazer upload do arquivo']);
    }

}
