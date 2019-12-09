<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use App\Models\Cnae;
use App\Models\Empresa;
use App\Models\Mensalidade;
use App\Models\Usuario;
use App\Notifications\NewEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateEmpresa
{

    public static function handle($data)
    {
        DB::beginTransaction();
        try {
            /** @var Empresa $empresa */

            $empresa = Auth::user()->empresas()->create($data);

            //Cadastra CNAEs (se existir)
            if (isset($data['cnaes']) && count($data['cnaes'])) {
                $empresa->cnaes()->createMany(Cnae::getCollectionFromCodes($data['cnaes']));
            }

            //Cadastra Sócios
            $empresa->socios()->createMany($data['socios']);

            //Cadastra Mensalidade
            $data['mensalidade']['id_usuario'] = $empresa->usuario->id;
            $data['mensalidade']['valor'] = Mensalidade::calculateMonthlyPayment($data['mensalidade'], $empresa->id_tipo_tributacao);
            $empresa->mensalidades()->create($data['mensalidade']);
            //Notifica admins que existe uma nova  empresa
            Usuario::notifyAdmins(new NewEmpresa($empresa));
            DB::commit();
            
        } catch (\Exception $e) {
            Log::critical($e);
            DB::rollback();
            return false;
        }
        return true;
    }
}