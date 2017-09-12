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
        'titulo_destaque' => 'required',
        'titulo' => 'required',
        'subtitulo' => 'required',
        'data_publicacao' => 'required|date_format:d/m/Y',
        'capa' => 'required',
        'conteudo' => 'required'
    ];

    protected static $niceNames = [
        'titulo_destaque' => 'Título de destaque', 'conteudo' => 'Conteúdo', 'titulo' => 'Título', 'subtitulo' => 'Subtítulo', 'capa' => 'Capa', 'data_publicacao' => 'Data de publicação'
    ];


}
