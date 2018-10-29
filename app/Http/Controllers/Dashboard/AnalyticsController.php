<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Models\AberturaEmpresa;
use App\Models\Alteracao;
use App\Models\AlteracaoContratual;
use App\Models\Apuracao;
use App\Models\Empresa;
use App\Models\OrdemPagamento;
use App\Models\ProcessoDocumentoContabil;
use App\Models\Usuario;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Composer\CaBundle\CaBundle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getBalanceHistory()
    {
        $initialDate = (new Carbon('first day of 12 months ago'))->format('Y-m');
        DB::enableQueryLog();
        $empresas = Auth::user()->empresas;
        $companyData = [];
        foreach ($empresas as $empresa) {
            $balancetes = $empresa->balancetes()->where('exercicio', '!=', null)->orderBy('exercicio', 'desc')->get()->reverse();
            if ($balancetes) {
                $receitasData = [];
                $despesasData = [];
                $resultData = [];
                foreach ($balancetes as $balancete) {
                    $receitasData[] = ['x' => $balancete->exercicio->format('U') * 1000, 'y' => ($balancete->receitas - 0), 'name' => 'Receitas', 'dataLabels' => ['format' => '{y}C', 'color'=>'#3CBC3C']];
                    $despesasData[] = ['x' => $balancete->exercicio->format('U') * 1000, 'y' => ($balancete->despesas - 0), 'color' => '#FF5050', 'name' => 'Despesas', 'dataLabels' => ['format' => '{y}D', 'color'=>'#FF5050']];
//                    $resultData[] = ['x' => $balancete->exercicio->format('U') * 1000, 'y' => ($balancete->receitas > $balancete->despesas ? $balancete->receitas - $balancete->despesas : $balancete->despesas - $balancete->receitas), 'name' => 'Resultado Final', 'type' => 'line'];
                }
                $companyData[] = ['data' => $receitasData, 'name' => $empresa->razao_social, 'type' => 'area', 'dataLabels'=>['enabled'=>true, 'style'=>['fontWeight'=>'normal']]];
                $companyData[] = ['data' => $despesasData, 'name' => $empresa->razao_social, 'linkedTo' => ':previous', 'type' => 'area', 'color'=>'#ff0000', 'dataLabels'=>['enabled'=>true, 'style'=>['fontWeight'=>'normal']]];
//                $companyData[] = ['data' => $resultData, 'name' => $empresa->razao_social, 'linkedTo' => ':previous', 'type' => 'line'];

            }

        }
        return response()->json($companyData);
    }

}
