<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Services\AddTributacaoToEmpresa;
use App\Services\RemoveTributacaoFromEmpresa;
use App\Services\UpdateTributacaoIsencao;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TributacaoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function store(Request $request, $idEmpresa)
    {
        if (AddTributacaoToEmpresa::handle($request, $idEmpresa)) {
            return redirect()->route('showEmpresaToAdmin', ['idEmpresa'=>$idEmpresa, 'tab'=>$request->get('tab')])->with('successAlert', 'Dados salvos com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function delete($idEmpresa, $idTributacao)
    {
        if (RemoveTributacaoFromEmpresa::handle($idTributacao)) {
            return redirect()->route('showEmpresaToAdmin', ['idEmpresa'=>$idEmpresa, 'tab'=>'tributacao'])->with('successAlert', 'Tributação removida com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function update(Request $request, $idEmpresa, $idTributacao)
    {
        if (UpdateTributacaoIsencao::handle($request, $idTributacao)) {
            return response()->json(['message'=>'ok']);
        }
        return response()->json(['message'=>'ocorreu um erro, veja o log']);
    }

}
