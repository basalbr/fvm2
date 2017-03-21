<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class NoticiaValidation extends Validation
{
    protected static $rules = [
        'titulo' => 'required', 'texto' => 'required', 'imagem' => 'required', 'created_at' => 'required'
    ];

    protected static $niceNames = [
        'titulo' => 'Título', 'texto' => 'Texto', 'imagem' => 'Imagem', 'created_at' => 'Data de Publicação'
    ];


}
