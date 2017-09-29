<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AberturaEmpresa;
use App\Models\Empresa;
use App\Models\EmpresaCnae;
use App\Models\Mensalidade;
use App\Models\OrdemPagamento;
use App\Models\Pessoa;
use App\Notifications\EmpresaActivated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class CreateEmpresaFromAberturaEmpresa
 * @package App\Services
 */
class CreateEmpresaFromAberturaEmpresa
{

    /**
     * @param $aberturaEmpresa
     * @return bool
     */
    public static function handle($aberturaEmpresa)
    {
        DB::beginTransaction();
        try {
            $aberturaEmpresa->status = 'Concluído';
            $aberturaEmpresa->save();
            $empresa = Empresa::create($aberturaEmpresa->toArray());
            //cadastra cnaes
            foreach ($aberturaEmpresa->cnaes as $cnae) {
                $empresa->cnaes()->create(['id_cnae' => $cnae->id_cnae]);
            }
            //cadastra socios
            foreach ($aberturaEmpresa->socios as $socio) {
                $socioArr = $socio->toArray();
                $socioArr['data_nascimento'] = $socio->data_nascimento->format('d/m/Y');
                $empresa->socios()->create($socioArr);
            }
            //cadastra mensalidade
            $qtde_documento_fiscal = $aberturaEmpresa->qtde_documento_fiscal;
            $qtde_funcionario = $aberturaEmpresa->qtde_funcionario;
            $valor = Mensalidade::calculateMonthlyPayment(compact('qtde_documento_fiscal', 'qtde_funcionario'));
            $id_usuario = $empresa->id_usuario;
            $mensalidade = $empresa->mensalidades()->create(compact('valor','qtde_funcionario','qtde_documento_fiscal', 'id_usuario'));
            //30 dias gratis
            OrdemPagamento::create([
                'id_referencia' => $mensalidade->id,
                'referencia' => $mensalidade->getTable(),
                'id_usuario' => $mensalidade->id_usuario,
                'valor' => $mensalidade->valor,
                'vencimento' => date('Y-m-d H:i:s', strtotime("+5 days")),
                'status' => 'Paga'
            ]);
            //aprova empresa
            $empresa->status = 'aprovado';
            $empresa->usuario->notify(new EmpresaActivated($empresa));
            $empresa->save();

            DB::commit();
        } catch (\Exception $e) {
            Log::critical($e->getMessage());
            DB::rollback();
            return false;
        }
        return true;
    }
}