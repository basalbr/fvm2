<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Anexo;
use App\Models\ImpostoRenda;
use App\Models\IrDeclarante;
use App\Models\IrDependente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SaveTempIR
{

    public static function handle(Request $request, int $id)
    {
        try {
            DB::beginTransaction();
            $request->merge(['status' => 'aguardando_conclusao']);
            /* @var $ir ImpostoRenda */
            $ir = self::getIrInstance($id, $request);
            $declarante = self::getDeclaranteInstance($ir, $request);

            if ($request->has('recibo_anterior')) {
                self::fileCheckAndMove($request->get('recibo_anterior'), $ir->getTable(), $ir->id);
            }
            if ($request->has('declaracao_anterior')) {
                self::fileCheckAndMove($request->get('declaracao_anterior'), $ir->getTable(), $ir->id);
            }
            if ($request->has('comprovante_residencia')) {
                self::fileCheckAndMove($request->get('comprovante_residencia'), $declarante->getTable(), $ir->id);
            }
            if ($request->has('rg')) {
                self::fileCheckAndMove($request->get('rg'), $declarante->getTable(), $ir->id);
            }
            if ($request->has('cpf')) {
                self::fileCheckAndMove($request->get('cpf'), $declarante->getTable(), $ir->id);
            }
            if ($request->has('titulo_eleitor')) {
                self::fileCheckAndMove($request->get('titulo_eleitor'), $declarante->getTable(), $ir->id);
            }
            if ($request->has('dependentes') && count($request->get('dependentes'))) {
                foreach ($request->get('dependentes') as $k => $dep) {
                    /* @var $dependente IrDependente */
                    $dep['id_imposto_renda'] = $ir->id;
                    $dependente = self::getDependenteInstance($ir, $k, $dep);
                    if (isset($dep['remover']) && count($dep['remover'])) {
                        self::removeAnexosInArray($dep['remover']);
                    }
                    if (isset($dep['cpf']) && !empty($dep['cpf'])) {
                        self::saveAnexo($dep['cpf'], 'CPF', $dependente->getTable(), $dependente->id);
                    }
                    if (isset($dep['rg']) && !empty($dep['rg'])) {
                        self::saveAnexo($dep['rg'], 'RG', $dependente->getTable(), $dependente->id);
                    }
                    if (isset($dep['anexos']) && count($dep['anexos'])) {
                        foreach ($dep['anexos'] as $arquivo) {
                            self::saveAnexo($arquivo['arquivo'], $arquivo['descricao'], $dependente->getTable(), $dependente->id);
                        }
                    }
                }
            }
            if ($request->has('remover') && count($request->get('remover'))) {
                self::removeAnexosInArray($request->get('remover'));
            }
            if ($request->has('anexos') && count($request->get('anexos'))) {
                foreach ($request->get('anexos') as $arquivo) {
                    self::saveAnexo($arquivo['arquivo'], $arquivo['descricao'], $ir->getTable(), $ir->id);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical($e);
            return false;
        }
    }

    private static function saveAnexo($filename, $description, $table, $id)
    {
        Anexo::create([
            'id_referencia' => $id,
            'referencia' => $table,
            'arquivo' => $filename,
            'descricao' => $description
        ]);
        self::fileCheckAndMove($filename, $table, $id);
    }

    private static function fileCheckAndMove($filename, $table, $id)
    {
        if (Storage::exists('temp/' . $filename)) {
            Storage::move('temp/' . $filename, 'public/anexos/' . $table . '/' . $id . '/' . $filename);
        }
    }

    private static function cleanDeclaracao(ImpostoRenda $ir)
    {
        $ir->recibo_anterior = null;
        $ir->declaracao_anterior = null;
        return $ir;
    }

    private static function cleanDeclarante(IrDeclarante $declarante)
    {
        $declarante->cpf = null;
        $declarante->rg = null;
        $declarante->titulo_eleitor = null;
        $declarante->comprovante_residencia = null;
        return $declarante;
    }

    private static function fileCheckAndRemove($filename, $table = null, $id = null)
    {
        if (Storage::exists('public/anexos/' . $table . '/' . $id . '/' . $filename)) {
            Storage::delete('public/anexos/' . $table . '/' . $id . '/' . $filename);
        }
        if (Storage::exists('temp/' . $filename)) {
            Storage::delete('temp/' . $filename);
        }
    }

    private static function removeAnexosInArray($ids)
    {
        foreach ($ids as $id) {
            $anexo = Anexo::find($id);
            self::fileCheckAndRemove($anexo->arquivo, $anexo->referencia, $anexo->id_referencia);
            $anexo->delete();
        }
    }

    private static function getIrInstance($id, $request)
    {
        $ir = Auth::user()->impostosRenda()->find($id);
        $ir = self::cleanDeclaracao($ir);
        if ($ir instanceof ImpostoRenda) {
            $ir->update($request->all());
            return $ir;
        }
        return Auth::user()->impostosRenda()->create($request->all());
    }

    private static function getDeclaranteInstance($ir, $request)
    {
        $declarante = $ir->declarante;
        $declarante = self::cleanDeclarante($declarante);
        if ($declarante instanceof IrDeclarante) {
            $declarante->update($request->all());
            return $declarante;
        }
        return $ir->declarante()->create($request->all());
    }

    private static function getDependenteInstance($ir, $id, $data)
    {
        $dependente = $ir->dependentes()->find($id);
        if ($dependente instanceof IrDependente) {
            $dependente->update($data);
            return $dependente;
        }
        return $ir->dependentes()->create($data);
    }

}