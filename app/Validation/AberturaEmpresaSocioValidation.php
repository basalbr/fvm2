<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

class AberturaEmpresaSocioValidation extends Validation
{

    protected static $rules = [
        'principal' => 'required|boolean',
        'nome' => 'required',
        'nome_mae' => 'required',
        'nome_pai' => 'required',
        'data_nascimento' => 'required|date',
        'estado_civil' => 'required',
        'regime_casamento' => 'sometimes|required',
        'nacionalidade' => 'required',
        'email' => 'required|email',
        'telefone' => 'required',
        'cpf' => 'required|size:14',
        'rg' => 'required',
        'orgao_expedidor' => 'required',
        'cep' => 'required|size:9',
        'id_uf' => 'required',
        'cidade' => 'required',
        'bairro' => 'required',
        'endereco' => 'required',
        'numero' => 'required|numeric',
    ];

    protected static $niceNames = [
        'nome' => 'Nome completo',
        'nome_mae' => 'Nome da mãe',
        'nome_pai' => 'Nome do pai',
        'principal' => 'É o sócio principal?',
        'data_nascimento' => 'Data de nascimento',
        'email' => 'E-mail',
        'telefone' => 'Telefone',
        'estado_civil' => 'Estado civil',
        'regime_casamento' => 'Regime de casamento',
        'cpf' => 'CPF',
        'rg' => 'RG',
        'nacionalidade' => 'Nacionalidade',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'CEP',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'complemento' => 'Complemento',
        'id_uf' => 'UF',
        'orgao_expedidor' => 'Órgão expedidor do RG',
    ];


}
