<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class HistoricoPagamentoValidation extends Validation
{
    protected static $rules = [
        'id_mensalidade' => 'required', 'status' => 'required', 'vencimento' => 'required'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'
    ];


}
