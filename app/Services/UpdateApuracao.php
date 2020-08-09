<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Apuracao;
use App\Models\HistoricoFaturamento;
use App\Models\RegistroAtividade;
use App\Notifications\GuiaAvailableInApuracao;
use App\Notifications\NewStatusApuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateApuracao
{

    public static function handle(Request $request, int $idApuracao)
    {
        DB::beginTransaction();
        try {

            /* @var Apuracao $apuracao */
            $apuracao = Apuracao::findOrFail($idApuracao);
            $statusAnterior = $apuracao->status;
            $apuracao->update($request->all());
            if (mb_strtolower($apuracao->imposto->nome) == 'simples nacional') {
                HistoricoFaturamento::where('competencia', $apuracao->competencia)->where('id_empresa', $apuracao->id_empresa)->delete();
                HistoricoFaturamento::create(['id_empresa' => $apuracao->id_empresa, 'competencia' => $apuracao->competencia, 'mercado' => 'interno', 'valor' => $request->get('faturamento_interno')]);
                HistoricoFaturamento::create(['id_empresa' => $apuracao->id_empresa, 'competencia' => $apuracao->competencia, 'mercado' => 'externo', 'valor' => $request->get('faturamento_externo')]);
            }
            if ($request->get('guia')) {
                Storage::move('temp/' . $request->get('guia'), 'public/anexos/' . $apuracao->getTable() . '/' . $apuracao->id . '/' . $request->get('guia'));
                $apuracao->empresa->usuario->notify(new GuiaAvailableInApuracao($apuracao));
            }
            if ($apuracao->status != $statusAnterior) {
                $apuracao->empresa->usuario->notify(new NewStatusApuracao($apuracao));
            }
            CheckDocumentosEmpresa::handle($apuracao->empresa, $apuracao->competencia);
            RegistroAtividade::create([
                'id_usuario' => Auth::user()->id,
                'id_referencia' => $apuracao->id,
                'referencia' => 'apuracao',
                'mensagem' => Auth::user()->nome . ' informou o status ' . $request->get('status')
            ]);
            RegistroAtividade::create([
                'id_usuario' => Auth::user()->id,
                'id_referencia' => $apuracao->id,
                'referencia' => 'apuracao',
                'mensagem' => Auth::user()->nome . ' informou o faturamento de ' . $request->get('faturamento_interno') . ' para o mercado interno e ' . $request->get('faturamento_externo') . ' para o mercado externo'
            ]);
            if ($request->has('tributo_interno')) {
                foreach ($request->get('tributo_interno') as $descricao => $valor) {
                    RegistroAtividade::create([
                        'id_usuario' => Auth::user()->id,
                        'id_referencia' => $apuracao->id,
                        'referencia' => 'apuracao',
                        'mensagem' => Auth::user()->nome . ' informou o faturamento de ' . $valor . ' em ' . $descricao . ' (mercado interno).'
                    ]);
                }
            }
            if ($request->has('tributo_externo')) {
                foreach ($request->get('tributo_externo') as $descricao => $valor) {
                    RegistroAtividade::create([
                        'id_usuario' => Auth::user()->id,
                        'id_referencia' => $apuracao->id,
                        'referencia' => 'apuracao',
                        'mensagem' => Auth::user()->nome . ' informou o faturamento de ' . $valor . ' em ' . $descricao . ' (mercado externo).'
                    ]);
                }
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