<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class MensalidadeValidation extends Validation
{
    protected static $rules = [
        'id_usuario' => 'required', 'id_pessoa' => 'required', 'duracao' => 'required', 'valor' => 'required|numeric', 'tipo' => 'required'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'
    ];


}
