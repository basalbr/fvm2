<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Empresa;
use App\Models\HistoricoFaturamento;
use App\Models\RegistroAtividade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateHistoricoFaturamento
{

    public static function handle(Request $request, $idEmpresa)
    {
        DB::beginTransaction();
        try {
            /** @var Empresa $empresa * */
            $empresa = Empresa::findOrFail($idEmpresa);
            //Atualiza a data de abertura
            if ($request->has('data_abertura')) {
                RegistroAtividade::create([
                    'id_usuario' => Auth::user()->id,
                    'id_referencia' => $empresa->id,
                    'referencia' => 'empresa',
                    'mensagem' => Auth::user()->nome . ' alterou a data de abertura de ' . $empresa->data_abertura . ' para ' . $request->get('data_abertura')
                ]);
                $empresa->update(['data_abertura' => $request->get('data_abertura')]);
            }
            //atualiza o histórico de faturamento
            if ($request->has('historico_faturamento_interno')) {
                $faturamentoToLog = '';
                foreach ($request->get('historico_faturamento_interno') as $competencia => $faturamento) {
                        $empresa->faturamentos()->where('mercado', 'interno')->where('competencia', $competencia)->delete();
                        $empresa->faturamentos()->create(['competencia' => $competencia, 'valor' => $faturamento, 'mercado'=>'interno']);
                        $faturamentoToLog .= $competencia . ' ' . $faturamento . ' ';
                }
                RegistroAtividade::create([
                    'id_usuario' => Auth::user()->id,
                    'id_referencia' => $empresa->id,
                    'referencia' => 'empresa',
                    'mensagem' => Auth::user()->nome . ' informou o seguinte histórico de faturamento interno: ' . $faturamentoToLog
                ]);
            }
            if ($request->has('historico_faturamento_externo')) {
                $faturamentoToLog = '';
                foreach ($request->get('historico_faturamento_externo') as $competencia => $faturamento) {
                    $empresa->faturamentos()->where('mercado', 'externo')->where('competencia', $competencia)->delete();
                    $empresa->faturamentos()->create(['competencia' => $competencia, 'valor' => $faturamento, 'mercado'=>'externo']);
                    $faturamentoToLog .= $competencia . ' ' . $faturamento . ' ';
                }
                RegistroAtividade::create([
                    'id_usuario' => Auth::user()->id,
                    'id_referencia' => $empresa->id,
                    'referencia' => 'empresa',
                    'mensagem' => Auth::user()->nome . ' informou o seguinte histórico de faturamento externo: ' . $faturamentoToLog
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }
}