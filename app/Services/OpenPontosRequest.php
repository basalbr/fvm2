<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\ContratoTrabalho;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\FuncionarioContrato;
use App\Models\FuncionarioDeficiencia;
use App\Models\Mensalidade;
use App\Models\OrdemPagamento;
use App\Models\Ponto;
use App\Models\Usuario;
use App\Notifications\EmpresaActivated;
use App\Notifications\FuncionarioActivated;
use App\Notifications\NewFuncionario;
use App\Notifications\PontosRequested;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OpenPontosRequest
{

    /**
     * @return bool
     */
    public static function handle()
    {
        DB::beginTransaction();
        try {
            $periodo = date('Y-m-d', strtotime('first day of last month'));

            $empresas = Empresa::whereDoesntHave('pontos', function ($query) use ($periodo) {
                $query->where('periodo', '=', $periodo);
            })->whereHas('funcionarios', function ($query) {
                $query->where('status', 'ativo');
            })->get();

            foreach ($empresas as $empresa) {
                $ponto = Ponto::create(['id_empresa' => $empresa->id, 'periodo' => $periodo]);
                $empresa->usuario->notify(new PontosRequested($ponto));
            }
            DB::commit();

        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}