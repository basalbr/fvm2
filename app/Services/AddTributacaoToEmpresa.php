<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Empresa;
use App\Models\FaixaSimplesNacional;
use App\Models\HistoricoFaturamento;
use App\Models\ImpostoFaixaSimplesNacional;
use App\Models\RegistroAtividade;
use App\Models\TributacaoIsencao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddTributacaoToEmpresa
{

    public static function handle(Request $request, $idEmpresa)
    {
        DB::beginTransaction();
        try {
            /** @var Empresa $empresa * */
            $empresa = Empresa::findOrFail($idEmpresa);

            $tributacao = $empresa->tributacoes()->create($request->all());
            if ($tributacao->mercado == 'externo') {
                $faixasSN = FaixaSimplesNacional::where('id_tabela_simples_nacional', $tributacao->id_tabela_simples_nacional)->get(['id'])->toArray();
                $impostosIsentosSN = ImpostoFaixaSimplesNacional::whereIn('id_faixa_simples_nacional', $faixasSN)->whereIn('descricao', ['IPI', 'PIS/Pasep', 'Cofins', 'ICMS', 'ISS'])->get(['id']);
                foreach($impostosIsentosSN as $imposto){
                    TributacaoIsencao::create(['id_tributacao'=>$tributacao->id, 'id_imposto_faixa_simples_nacional'=>$imposto->id]);
                }
            }
            RegistroAtividade::create([
                'id_usuario' => Auth::user()->id,
                'id_referencia' => $empresa->id,
                'referencia' => 'empresa',
                'mensagem' => Auth::user()->nome . ' adicionou uma tributacao: ' . $request->get('descricao')
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }
}