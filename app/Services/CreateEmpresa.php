<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;

class CreateEmpresa
{
    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            $empresa = new Pessoa($data);
            $empresa->cnaes()->createMany($data['cnaes']);
            $empresa->socios()->createMany($data['socios']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }

}