<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Services\UpdateHistoricoFaturamento;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HistoricoFaturamentoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function store(Request $request, $idEmpresa)
    {
        if (UpdateHistoricoFaturamento::handle($request, $idEmpresa)) {
            return redirect()->route('showEmpresaToAdmin', ['idEmpresa'=>$idEmpresa, 'tab'=>$request->get('tab')])->with('successAlert', 'Dados salvos com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }


}
