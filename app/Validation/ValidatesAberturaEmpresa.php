<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

trait ValidatesAberturaEmpresa
{
    use ValidatesModel;

    protected static $rules = [
        'id_usuario' => 'sometimes|required',
        'nome_empresarial1' => 'required',
        'nome_empresarial2' => 'required',
        'nome_empresarial3' => 'required',
        'enquadramento' => 'required',
        'capital_social' => 'required',
        'id_natureza_juridica' => 'required',
        'id_tipo_tributacao' => 'sometimes|required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'numeric|required',
        'id_uf' => 'required',
        'iptu' => 'required',
        'area_total' => 'required|numeric',
        'area_ocupada' => 'required|numeric',
        'cpf_cnpj_proprietario' => 'required',
    ];

    protected static $niceNames = [
        'nome_empresarial1' => 'Nome Empresarial Preferencial',
        'nome_empresarial2' => 'Nome Empresarial Alternativo 1',
        'nome_empresarial3' => 'Nome Empresarial Alternativo 2',
        'enquadramento' => 'Enquadramento da empresa',
        'capital_social' => 'Capital Social',
        'id_natureza_juridica' => 'Natureza Jurídica',
        'id_tipo_tributacao' => 'Tipo de Tributação',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'CEP',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'complemento' => 'Complemento',
        'id_uf' => 'Estado',
        'iptu' => 'Inscrição IPTU ',
        'area_total' => 'Área total do imóvel m²',
        'area_ocupada' => 'Área total ocupada em m²',
        'cpf_cnpj_proprietario' => 'CPF ou CNPJ do proprietário do imóvel',
    ];



}
