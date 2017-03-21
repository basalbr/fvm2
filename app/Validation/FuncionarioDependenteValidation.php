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
        'id_usuario' => 'sometimes|required',
        'nome_empresarial1' => 'required',
        'nome_empresarial2' => 'required',
        'nome_empresarial3' => 'required',
        'enquadramento' => 'required',
        'capital_social' => 'required',
        'id_natureza_juridica' => 'required',
        'id_tipo_tributacao' => 'sometimes',
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
        'socios' => 'required',
        'socios.*.id_abertura_empresa' => 'required',
        'socios.*.nome' => 'required',
        'socios.*.nome_mae' => 'required',
        'socios.*.nome_pai' => 'required',
        'socios.*.principal' => 'required|boolean',
        'socios.*.data_nascimento' => 'required|date',
        'socios.*.email' => 'required|email',
        'socios.*.telefone' => 'required',
        'socios.*.estado_civil' => 'required',
        'socios.*.regime_casamento' => 'sometimes|required',
        'socios.*.cpf' => 'required|size:14',
        'socios.*.rg' => 'required',
        'socios.*.nacionalidade' => 'required',
        'socios.*.endereco' => 'required',
        'socios.*.bairro' => 'required',
        'socios.*.cep' => 'required|size:9',
        'socios.*.cidade' => 'required',
        'socios.*.numero' => 'required|numeric',
        'socios.*.id_uf' => 'required',
        'socios.*.orgao_expedidor' => 'required',
        'cnaes' => 'required',
        'cnaes.*.id_abertura_empresa' => 'required',
        'cnaes.*.id_cnae' => 'required'
    ];

    protected static $niceNames = [
        'nome_empresarial1' => 'Nome empresarial preferencial',
        'nome_empresarial2' => 'Nome empresarial alternativo',
        'nome_empresarial3' => 'Nome empresarial alternativo 2',
        'enquadramento' => 'Enquadramento da empresa',
        'capital_social' => 'Capital social',
        'id_natureza_juridica' => 'Natureza jurídica',
        'id_tipo_tributacao' => 'Tipo de tributação',
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
        'socios' => 'É necessário informar pelo menos o sócio principal',
        'socios.*.nome' => 'É necessário informar o nome dos sócio',
        'socios.*.nome_mae' => 'Nome da mãe',
        'socios.*.nome_pai' => 'Nome do pai',
        'socios.*.principal' => 'É o sócio principal',
        'socios.*.data_nascimento' => 'Data de nascimento',
        'socios.*.email' => 'E-mail',
        'socios.*.telefone' => 'Telefone',
        'socios.*.estado_civil' => 'Estado civil',
        'socios.*.regime_casamento' => 'Regime de casamento',
        'socios.*.cpf' => 'CPF',
        'socios.*.rg' => 'RG',
        'socios.*.nacionalidade' => 'Nacionalidade',
        'socios.*.endereco' => 'Endereço',
        'socios.*.bairro' => 'Bairro',
        'socios.*.cep' => 'CEP',
        'socios.*.cidade' => 'Cidade',
        'socios.*.numero' => 'Número',
        'socios.*.id_uf' => 'UF',
        'socios.*.orgao_expedidor' => 'Órgão expedidor',
        'cnaes.*.id_abertura_empresa' => 'Processo de abertura de empresa',
        'cnaes.*.id_cnae' => 'Código do CNAE',
        'cnaes' => 'CNAEs',
    ];


}
