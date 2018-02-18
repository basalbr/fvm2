<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class ImpostoRendaValidation extends Validation
{

    protected static $rules = [
        'nome' => 'required|max:191',
        'recibo_anterior' => 'required_if:fez_declaracao,1|nullable',
        'declaracao_anterior' => 'required_if:fez_declaracao,1|nullable',
        'cpf' => 'required_if:fez_declaracao,0|max:10240|nullable',
        'titulo_eleitor' => 'required_if:fez_declaracao,0|nullable',
        'rg' => 'required_if:fez_declaracao,0|max:10240|nullable',
        'data_nascimento' => 'required_if:fez_declaracao,0|nullable|date_format:d/m/Y',
        'comprovante_residencia' => 'required',
        'dependentes.*.rg'=>'required',
        'dependentes.*.cpf'=>'required'
    ];

    protected static $niceNames = [
        'nome' => 'Nome Completo',
        'recibo_anterior' => 'Cópia do recibo da declaração do ano anterior',
        'declaracao_anterior' => 'Cópia da declaração do ano anterior',
        'cpf' => 'CPF',
        'titulo_eleitor' => 'Título de Eleitor',
        'rg' => 'RG',
        'data_nascimento' => 'Data de Nascimento',
        'comprovante_residencia' => 'Comprovante de Residência',
        'dependentes.*.rg' => 'RG dos dependentes',
        'dependentes.*.cpf' => 'CPF dos dependentes'
    ];


}
