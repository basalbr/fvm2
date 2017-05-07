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
     * @param int $qtdeDocContabil
     * @param int $qtdeProLabore
     * @return bool|float
     */
    public static function handle(int $qtdeFuncionarios, int $qtdeDocFiscal, int $qtdeDocContabil, int $qtdeProLabore)
    {
        $plano = Plano::where('total_documento_fiscal', '>=', $qtdeDocFiscal)
            ->where('total_documento_contabil', '>=', $qtdeDocContabil)
            ->where('total_pro_labore', '>=', $qtdeProLabore)
            ->orderBy('valor', 'asc')
            ->first();
        if ($plano instanceof Plano) {
            return $plano->valor + (Config::getFuncionarioIncrementalPrice() * $qtdeFuncionarios);
        }
        return false;
    }
}