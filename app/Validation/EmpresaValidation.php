<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:37
 */

namespace App\Validation;

/**
 * Class EmpresaValidation
 * @package App\Validation
 */
class EmpresaValidation extends Validation
{

    protected static $rules = [
        'id_usuario' => 'required',
        'id_natureza_juridica' => 'required',
        'id_tipo_tributacao' => 'required',
        'id_enquadramento_empresa' => 'required',
        'cnpj' => 'required|unique:empresa,cnpj|size:18',
        'inscricao_estadual' => 'unique:empresa,inscricao_estadual',
        'inscricao_municipal' => 'unique:empresa,inscricao_municipal',
        'qtde_funcionarios' => 'required|numeric',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'numeric',
        'id_uf' => 'required',
        'codigo_acesso_simples_nacional' => 'numeric',
        'nome_fantasia' => 'required',
        'razao_social' => 'required|unique:empresa,razao_social',
        'socios' => 'required|array|min:1',
        'socios.*.nome' => 'required',
        'socios.*.principal' => 'required',
        'socios.*.cpf' => 'required|size:14|unique:socio,cpf',
        'socios.*.rg' => 'required|unique:socio,rg',
        'socios.*.endereco' => 'required',
        'socios.*.bairro' => 'required',
        'socios.*.cep' => 'required|size:9',
        'socios.*.cidade' => 'required',
        'socios.*.numero' => 'numeric',
        'socios.*.id_uf' => 'required',
        'socios.*.pro_labore' => 'numeric',
        'socios.*.orgao_expedidor' => 'required',
        'socios.*.pis' => 'size:14',
        'socios.*.data_nascimento' => 'required|date',
        'socios.*.titulo_eleitor' => 'required',
        'cnaes' => 'required|array|min:1',
        'cnaes.*.id_abertura_empresa' => 'required',
        'cnaes.*.id_cnae' => 'required'
    ];

    protected static $niceNames = [
        'id_natureza_juridica' => 'Natureza Jurídica',
        'cpf_cnpj' => 'CNPJ',
        'inscricao_estadual' => 'Inscrição Estadual',
        'inscricao_municipal' => 'Inscrição Municipal',
        'qtde_funcionarios' => 'Quantidade de Funcionários',
        'tipo' => 'tipo',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'Cep',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'id_uf' => 'Estado',
        'codigo_acesso_simples_nacional' => 'Código de Acesso do Simples Nacional',
        'nome_fantasia' => 'Nome Fantasia',
        'razao_social' => 'Razão Social',
        'id_tipo_tributacao' => 'Tipo de Tributação',
        'crc' => 'Número de registro do CRC do contador atual',
        'socios' => 'Sócios',
        'socios.*.nome' => 'Nome',
        'socios.*.principal' => 'É o sócio principal?',
        'socios.*.cpf' => 'CPF',
        'socios.*.rg' => 'RG',
        'socios.*.titulo_eleitor' => 'Título de eleitor',
        'socios.*.endereco' => 'Endereço',
        'socios.*.bairro' => 'Bairro',
        'socios.*.cep' => 'CEP',
        'socios.*.cidade' => 'Cidade',
        'socios.*.numero' => 'Número',
        'socios.*.id_uf' => 'UF',
        'socios.*.pro_labore' => 'Valor de pró-labore',
        'socios.*.orgao_expedidor' => 'Órgão expedidor do RG',
        'socios.*.pis' => 'PIS',
        'socios.*.data_nascimento' => 'Data de nascimento',
        'cnaes' => 'CNAEs',
        'cnaes.*.id_abertura_empresa' => 'Processo de abertura de empresa',
        'cnaes.*.id_cnae' => 'Código do CNAE'
    ];


}
