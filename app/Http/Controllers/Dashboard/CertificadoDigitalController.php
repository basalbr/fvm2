<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AberturaEmpresa;
use App\Models\Empresa;
use App\Models\EnquadramentoEmpresa;
use App\Models\NaturezaJuridica;
use App\Models\RegimeCasamento;
use App\Models\TipoTributacao;
use App\Models\Uf;
use App\Services\CreateEmpresa;
use App\Services\CreateEmpresaFromAberturaEmpresa;
use App\Services\SendMessageToAdmin;
use App\Services\UploadFile;
use App\Validation\EmpresaValidation;
use App\Validation\MensagemValidation;
use App\Validation\SocioValidation;
use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CertificadoDigitalController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $empresas = Auth::user()->empresas()->orderBy('razao_social')->get();
        return view('dashboard.certificado_digital.index', compact("empresas"));
    }

    public function delete($idEmpresa)
    {
        try {
            $empresa = Auth::user()->empresas()->findOrFail($idEmpresa);
            $empresa->certificado_digital = null;
            $empresa->save();
            DB::commit();
            return redirect()->route('listCertificadosToUser')->with('successAlert', 'Certificado removido com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errorAlert', 'Não foi possível salvar seu certificado, tente novamente mais tarde.');
        }
    }

    public function upload(Request $request)
    {
        try {
            DB::beginTransaction();
            /* @var $empresa Empresa */
            $empresa = Auth::user()->empresas()->findOrFail($request->get('id_empresa'));
            $filename = md5(random_bytes(5)) . '.' . $request->file('certificado')->getClientOriginalExtension();
            $empresa->update(['certificado_digital' => $filename, 'senha_certificado_digital' => $request->get('senha')]);
            $request->file('certificado')->storeAs('certificados/' . $request->get('id_empresa') . '/', $filename, 'public');
            DB::commit();
            return redirect()->route('listCertificadosToUser')->with('successAlert', 'Certificado enviado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errorAlert', 'Não foi possível salvar seu certificado, tente novamente mais tarde.');
        }

    }

}
