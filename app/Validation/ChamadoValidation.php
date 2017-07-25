<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ChamadoValidation extends Validation
{
    protected static $rules = [
        'id_tipo_chamado' => 'required|exists:tipo_chamado,id',
        'mensagem' => 'required',
        'anexos.*.arquivo' => 'max:191',
        'anexos.*.descricao' => 'max:191'
    ];

    protected static $niceNames = [
        'id_tipo_chamado' => 'Assunto',
        'mensagem' => 'Mensagem',
        'anexos.*.arquivo' => 'Anexo',
        'anexos.*.descricao' => 'Descrição'
    ];
}
