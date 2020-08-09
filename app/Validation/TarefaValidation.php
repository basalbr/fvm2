<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class TarefaValidation extends Validation
{
    protected static $rules = [
        'assunto' => 'required',
        'data' => 'required|date_format:d/m/Y',
        'hora' => 'required|date_format:H:i',
        'responsavel' => 'required',
        'mensagem' => 'required',
    ];

    protected static $niceNames = [
        'assunto' => 'Assunto',
        'mensagem' => 'Mensagem',
        'responsavel' => 'Responsável',
        'data' => 'Data de expectativa de conclusão',
        'hora' => 'Hora de expectativa de conclusão'
    ];


}
