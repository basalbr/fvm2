<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AberturaEmpresa;
use Illuminate\Support\Facades\DB;

class CreateAberturaEmpresa
{

    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            $aberturaEmpresa = new AberturaEmpresa($data);
            $aberturaEmpresa->cnaes()->createMany($data['cnaes']);
            $aberturaEmpresa->socios()->createMany($data['socios']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }
}