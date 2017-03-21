<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AberturaEmpresa;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;

class CreateEmpresaFromAberturaEmpresa
{
    const PENDENTE = 'pendente';
    const NOVO = 'novo';
    const CANCELADO = 'cancelado';
    const ATENCAO = 'atencao';
    const CONCLUIDO = 'concluido';

    /**
     * @param array $data
     * @return bool
     */
    public static function handle(array $data)
    {
        DB::beginTransaction();
        try {
            $empresa = new Pessoa($data);
            $empresa->cnaes()->createMany($data['cnaes']);
            $empresa->socios()->createMany($data['socios']);
            AberturaEmpresa::find($data['id_abertura_empresa'])->status(static::CONCLUIDO)->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }
}