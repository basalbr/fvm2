<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\AberturaEmpresa;
use App\Models\Cnae;
use App\Models\Config;
use App\Models\Usuario;
use App\Notifications\NewAberturaEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateAberturaEmpresa
{

    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            /** @var AberturaEmpresa $aberturaEmpresa */
            $aberturaEmpresa = Auth::user()->aberturasEmpresa()->create($data);
            //Cadastra CNAEs (se existir)
            if (isset($data['cnaes']) && count($data['cnaes'])) {
                $aberturaEmpresa->cnaes()->createMany(Cnae::getCollectionFromCodes($data['cnaes']));
            }
            //Cadastra Sócios
            $aberturaEmpresa->socios()->createMany($data['socios']);

            //Abre ordem de pagamento
            CreateOrdemPagamento::handle($aberturaEmpresa->usuario, $aberturaEmpresa->getTable(), $aberturaEmpresa->id, Config::getAberturaEmpresaPrice());

            //Notifica admins que existe uma nova abertura de empresa
            Usuario::notifyAdmins(new NewAberturaEmpresa($aberturaEmpresa));
            DB::commit();
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}