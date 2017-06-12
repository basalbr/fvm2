<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class FuncionarioDependenteValidation extends Validation
{

    protected static $rules = [
        'nome' => 'required|max:191',
        'data_nascimento' => 'required|date_format:d/m/Y',
        'local_nascimento' => 'required|max:191',
        'cpf' => 'nullable|size:14',
        'rg' => 'nullable|max:14',
        'matricula' => 'nullable|max:191',
        'cartorio' => 'nullable|max:191',
        'numero_cartorio' => 'nullable|max:191',
        'numero_folha' => 'nullable|max:191',
        'numero_dnv' => 'nullable|max:191',
        'id_tipo_dependencia' => 'required|exists:tipo_dependencia,id',
        'orgao_expedidor_rg' => 'nullable|max:191',
        'numero_livro' => 'nullable|max:191'
    ];

    protected static $niceNames = [
        'nome' => 'Nome completo',
        'data_nascimento' => 'Data de nascimento',
        'local_nascimento' => 'Local de nascimento',
        'cpf' => 'CPF',
        'rg' => 'RG',
        'matricula' => 'Matrícula',
        'cartorio' => 'Cartório',
        'numero_cartorio' => 'Número do cartório',
        'numero_folha' => 'Número da folha',
        'numero_dnv' => 'Número do D.N.V',
        'id_tipo_dependencia' => 'Tipo de dependência',
        'orgao_expedidor_rg' => 'Órgão expedidor do RG',
        'numero_livro' => 'Número do livro'
    ];


}
