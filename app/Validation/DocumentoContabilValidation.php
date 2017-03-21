<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class DocumentoContabilValidation extends Validation
{
    protected static $rules = [
        'descricao' => 'required', 'anexo' => 'required', 'id_processo_documento_contabil' => 'required'
    ];

    protected static $niceNames = [
        'descricao' => 'Descrição', 'anexo' => 'Anexo', 'id_processo_documento_contabil' => 'Processo de Documentos Contábeis'
    ];
}
