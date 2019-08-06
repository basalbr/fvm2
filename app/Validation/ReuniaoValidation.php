<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ReuniaoValidation extends Validation
{
    protected static $rules = [
        'data' => 'required',
        'id_reuniao_horario' => 'required|exists:reuniao_horario,id',
        'assunto' => 'required',
    ];

    protected static $niceNames = [
        'id_reuniao_horario' => 'Horário',
        'assunto' => 'Assunto',
        'data' => 'Data'
    ];
}
