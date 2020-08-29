<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:29
 */

namespace App\Models;

use App\Services\CalculateMonthlyPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * @property integer id
 * @property integer id_usuario
 * @property string nome_empresarial1
 * @property string nome_empresarial2
 * @property string nome_empresarial3
 * @property string capital_social
 * @property integer id_natureza_juridica
 * @property integer id_tipo_tributacao
 * @property string cep
 * @property integer id_uf
 * @property string cidade
 * @property string endereco
 * @property string bairro
 * @property integer numero
 * @property string complemento
 * @property string iptu
 * @property integer area_total
 * @property integer area_ocupada
 * @property string cpf_cnpj_proprietario
 * @property string cnae_duvida
 * @property string status
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 * @property integer id_enquadramento_empresa
 * @property integer qtde_funcionario
 * @property integer qtde_documento_fiscal
 * @property integer qtde_documento_contabil
 * @property boolean is_servico
 * @property boolean is_comercio
 * @property boolean is_industria
 * @property Usuario usuario
 */
class AberturaEmpresa extends Model
{
    /**
     * Use Soft Deletes trait
     */
    use SoftDeletes, ValidatesRequests;

    const PENDENTE = 'pendente';
    const NOVO = 'novo';
    const CANCELADO = 'cancelado';
    const ATENCAO = 'atencao';
    const CONCLUIDO = 'concluido';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'nome_empresarial1',
        'nome_empresarial2',
        'nome_empresarial3',
        'id_enquadramento_empresa',
        'capital_social',
        'id_natureza_juridica',
        'id_tipo_tributacao',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'numero',
        'complemento',
        'id_uf',
        'iptu',
        'area_total',
        'area_ocupada',
        'cpf_cnpj_proprietario',
        'status',
        'cnae_duvida',
        'qtde_funcionario',
        'qtde_documento_fiscal',
        'qtde_documento_contabil',
        'is_comercio',
        'is_servico',
        'is_industria'
    ];

    protected $status_processo = [
        'pedido_inicial_em_analise' => 'Nossa equipe está analisando seu pedido',
        'pedido_inicial_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'viabilidade_em_analise' => 'O pedido de viabilidade está em análise pelos órgãos responsáveis',
        'viabilidade_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'dbe_em_analise' => 'O DBE está em análise pela Receita Federal',
        'dbe_aguardando_usuario' => 'Precisamos de mais informações para o DBE',
        'requerimento_aguardando_protocolo' => 'Estamos aguardando sua assinatura digital do processo junto à JUCESC',
        'requerimento_em_analise' => 'O requerimento está em análise na JUCESC',
        'requerimento_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'inscricao_estadual_aguardando_protocolo' => 'Estamos aguardando sua confirmação de protocolo junto à SEF',
        'inscricao_estadual_em_analise' => 'O processo está em análise na SEF',
        'inscricao_estadual_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'alvara_aguardando_protocolo' => 'Estamos aguardando o protocolo da documentação na prefeitura',
        'alvara_em_analise' => 'A documentação está sendo analisada pela prefeitura',
        'alvara_aguardando_pagamento' => 'Estamos aguardando o comprovante de pagamento das taxas',
        'alvara_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'simples_nacional_em_analise' => 'O pedido de opção pelo Simples Nacional está em análise',
        'simples_nacional_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'concluido' => 'Esse processo está concluído',
        'cancelado' => 'Esse processo foi cancelado',
        'pendente' => 'Nossa equipe recebeu seu pedido',
        'em_analise' => 'Estamos analisando seu pedido',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return bool
     */
    public function isSimplesNacional()
    {
        if ($this->cnaes()->where('id_tabela_simples_nacional', '=', null)->count()) {
            return false;
        }
        return true;

    }

    public function getDescricaoEtapa()
    {
        return $this->status_processo[mb_strtolower($this->status)];
    }

    public function getEtapa()
    {
        if(strpos($this->status, 'pendente')){
            return 'pendente';
        }elseif(strpos($this->status, 'concluido')===0){
            return 'concluido';
        }elseif(strpos($this->status, 'cancelado')===0){
            return 'cancelado';
        }elseif(strpos($this->status, 'pedido_inicial')===0){
            return 'pedido_inicial';
        }elseif(strpos($this->status, 'viabilidade')===0){
            return 'viabilidade';
        }elseif(strpos($this->status, 'dbe')===0){
            return 'dbe';
        }elseif(strpos($this->status, 'requerimento')===0){
            return 'requerimento';
        }elseif(strpos($this->status, 'inscricao_estadual')===0){
            return 'inscricao_estadual';
        }elseif(strpos($this->status, 'alvara')===0){
            return 'alvara';
        }elseif(strpos($this->status, 'simples_nacional')===0){
            return 'simples_nacional';
        }
        return 'pendente';
    }

    public function getNomeEtapa()
    {
        if(strpos($this->status, 'pendente')===0){
            return 'Pendente';
        }elseif(strpos($this->status, 'concluido')===0){
            return 'Concluído';
        }elseif(strpos($this->status, 'cancelado')===0){
            return 'Cancelado';
        }elseif(strpos($this->status, 'pedido_inicial')===0){
            return 'Em análise';
        }elseif(strpos($this->status, 'viabilidade')===0){
            return 'Viabilidade';
        }elseif(strpos($this->status, 'dbe')===0){
            return 'DBE';
        }elseif(strpos($this->status, 'requerimento')===0){
            return 'Requerimento';
        }elseif(strpos($this->status, 'inscricao_estadual')===0){
            return 'Inscrição Estadual';
        }elseif(strpos($this->status, 'alvara')===0){
            return 'Alvará';
        }elseif(strpos($this->status, 'simples_nacional')===0){
            return 'Simples Nacional';
        }
        return 'Pendente';
    }

    public function delete()
    {
        if ($this->ordemPagamento->count()) {
            $this->ordemPagamento->delete();
        }
        if ($this->socios->count()) {
            foreach ($this->socios as $socio) {
                $socio->delete();
            }
        }
        if ($this->mensagens->count()) {
            foreach ($this->mensagens as $mensagem) {
                $mensagem->delete();
            }
        }
        if ($this->cnaes->count()) {
            foreach ($this->cnaes as $cnae) {
                $cnae->delete();
            }
        }
        if ($this->anotacoes->count()) {
            foreach ($this->anotacoes() as $anotacao) {
                $anotacao->delete();
            }
        }
        parent::delete();
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


    public function getNomeEmpresarial1Attribute($attr)
    {
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function getNomeEmpresarial2Attribute($attr)
    {
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function getNomeEmpresarial3Attribute($attr)
    {
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    /**
     * @return AberturaEmpresaSocio
     */
    public function getSocioPrincipal()
    {
        return $this->socios()->where('principal', '=', 1)->first();
    }

    /**
     * @return mixed
     */
    public function getPaymentStatus()
    {
        return OrdemPagamento::where('referencia', '=', $this->getTable())->where('id_referencia', '=', $this->id)->first()->status;
    }

    /**
     * @return string
     */
    public function getMonthlyPayment()
    {
        $qtdeProLabore = $this->socios()->where('pro_labore', '>', 0)->count();
        return 'R$ ' . number_format(CalculateMonthlyPayment::handle($this->qtde_funcionario, $this->qtde_documento_fiscal, $this->qtde_documento_contabil, $qtdeProLabore), 2, ',', '.');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cnaes()
    {
        return $this->hasMany(AberturaEmpresaCnae::class, 'id_abertura_empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uf()
    {
        return $this->belongsTo(Uf::class, 'id_uf');
    }

    /**
     * @return mixed
     */
    public function ordemPagamento()
    {
        return $this->hasOne(OrdemPagamento::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function naturezaJuridica()
    {
        return $this->belongsTo(NaturezaJuridica::class, 'id_natureza_juridica');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enquadramentoEmpresa()
    {
        return $this->belongsTo(EnquadramentoEmpresa::class, 'id_enquadramento_empresa');
    }

    /**
     * @return integer
     */
    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->usuario->id)->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoTributacao()
    {
        return $this->belongsTo(TipoTributacao::class, 'id_tipo_tributacao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socios()
    {
        return $this->hasMany(AberturaEmpresaSocio::class, 'id_abertura_empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function getQtdMensagensNaoLidas($isAdmin = false)
    {
        if ($isAdmin) {
            return $this->mensagens()->where('from_admin', 1)->where('lida', 0)->count();
        }
        return $this->mensagens()->where('from_admin', 0)->where('lida', 0)->count();
    }

}