<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AberturaEmpresa;
use App\Models\Mensagem;
use Illuminate\Support\Facades\DB;

class SendMessageToAdmin
{

    /**
     * @param array $data
     * @param string $reference
     * @return bool
     */
    public static function handle(array $data, string $reference)
    {
        DB::beginTransaction();
        try {
            $data['referencia'] = $reference;
            Mensagem::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }
}