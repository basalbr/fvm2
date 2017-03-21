<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class PlanoPagamentoValidation extends Validation
{
    protected static $rules = [
        'descricao' => 'required', 'valor' => 'required|numeric', 'total_documentos_contabeis' => 'required|numeric', 'total_documentos' => 'required|numeric', 'pro_labores' => 'required|numeric', 'funcionarios' => 'required|numeric', 'nome' => 'required', 'duracao' => 'required|integer'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'
    ];
}
