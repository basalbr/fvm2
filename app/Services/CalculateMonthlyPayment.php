<?php

namespace App\Services;

use App\Models\Config;
use App\Models\Plano;
use Illuminate\Support\Facades\DB;

class CalculateMonthlyPayment
{
    /**
     * @param int $qtdeFuncionarios
     * @param int $qtdeDocFiscal
     * @return bool|float
     */
    public static function handle(int $qtdeFuncionarios, int $qtdeDocFiscal)
    {
        $plano = Plano::where('total_documento_fiscal', '>=', $qtdeDocFiscal)
            ->orderBy('valor', 'asc')
            ->first();
        if ($plano instanceof Plano) {
            return $plano->valor + (Config::getFuncionarioIncrementalPrice() * $qtdeFuncionarios);
        }
        return false;
    }
}