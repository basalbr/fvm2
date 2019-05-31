<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

/**
 * @property integer id
 * @property integer id_abertura_empresa
 * @property string nome
 * @property string nome_mae
 * @property string nome_pai
 * @property boolean principal
 * @property \DateTime data_nascimento
 * @property string estado_civil
 * @property string email
 * @property string telefone
 * @property string cpf
 * @property string rg
 * @property string orgao_expedidor
 * @property string nacionalidade
 * @property string cep
 * @property integer id_uf
 * @property string endereco
 * @property integer numero
 * @property string complemento
 * @property string bairro
 * @property string cidade
 * @property double pro_labore
 * @property integer id_regime_casamento
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 * @property AberturaEmpresa empresa
 * @property Uf uf
 * @property RegimeCasamento regimeCasamento
 * @property Cnae cnae
 */
class Alteracao extends Model
{

    use SoftDeletes;

    protected $rules = ['id_pessoa' => 'required', 'id_tipo_alteracao' => 'required'];
    protected $errors;
    protected $niceNames = ['id_pessoa' => 'Empresa', 'id_tipo_alteracao' => 'Tipo de Alteração'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'id_usuario', 'status', 'id_tipo_alteracao'];

    protected $status_processo = [
        'pedido_inicial_em_analise' => 'Nossa equipe está analisando seu pedido',
        'pedido_inicial_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'viabilidade_em_analise' => 'O pedido de viabilidade está em análise pelos órgãos responsáveis',
        'viabilidade_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'dbe_em_analise' => 'O DBE está em análise pela Receita Federal',
        'dbe_aguardando_usuario' => 'Precisamos de mais informações para o DBE',
        'requerimento_aguardando_protocolo' => 'Estamos aguardando sua confirmação de protocolo junto à JUCESC',
        'requerimento_em_analise' => 'O requerimento está em análise na JUCESC',
        'requerimento_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'alvara_aguardando_protocolo' => 'Estamos aguardando o protocolo da documentação na prefeitura',
        'alvara_em_analise' => 'A documentação está sendo analisada pela prefeitura',
        'alvara_aguardando_pagamento' => 'Estamos aguardando o comprovante de pagamento das taxas',
        'alvara_aguardando_usuario' => 'Precisamos de mais informações para darmos continuidade',
        'concluido' => 'Esse processo está concluído',
        'cancelado' => 'Esse processo foi cancelado',
        'pendente' => 'Nossa equipe recebeu seu pedido',
    ];

    public function getDescricaoEtapa()
    {
        return $this->status_processo[$this->status];
    }

    public function getStatusAttribute($status){
        return strtolower($status);
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
        }elseif(strpos($this->status, 'alvara')===0){
            return 'alvara';
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
        }elseif(strpos($this->status, 'alvara')===0){
            return 'Alvará';
        }elseif(strpos($this->status, 'concluído')===0){
            return 'Concluído';
        }
        return 'Pendente';
    }

    public function validateMeiMe($data)
    {
        $rules = ['id_pessoa' => 'required', 'titulo_eleitor' => 'required', 'recibo_ir' => 'sometimes'];
        $niceNames = ['id_pessoa' => 'Empresa', 'titulo_eleitor' => 'Título de Eleitor', 'recibo_ir' => 'Número do Recibo do Último Imposto de Renda'];
        return $this->validate($data, $rules, $niceNames);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }


    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoAlteracao::class, 'id_tipo_alteracao');
    }

    public function informacoes()
    {
        return $this->hasMany(AlteracaoInformacao::class, 'id_alteracao');
    }

    public function getUltimaMensagem()
    {
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function pagamento()
    {
        return $this->hasOne(OrdemPagamento::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function tipos()
    {
        return $this->hasMany(AlteracaoTipoAlteracao::class, 'id_alteracao');
    }

    public function getDescricao()
    {
        return $this->id_tipo_alteracao ? $this->tipo->descricao : $this->getTiposDescricao();
    }

    public function getLabelMensagensNaoLidasAdmin(){
        return $this->getQtdeMensagensNaoLidasAdmin() > 0 ?
            ' <span class="label label-warning">'.$this->getQtdeMensagensNaoLidasAdmin() . ($this->getQtdeMensagensNaoLidasAdmin() == 1 ? ' mensagem não lida' : ' mensagens não lidas').'</td></span>' : '';
    }

    private function getTiposDescricao()
    {
        $descricao = '';
        foreach ($this->tipos as $tipo) {
            $descricao .= $tipo->tipo->descricao . ' / ';
        }
        return substr_replace($descricao, "", -2);
    }

    public function getLabelEtapa(){
        if(strpos($this->status, 'pendente')===0){
            return '<span class="label label-primary">Pendente</span>';
        }elseif(strpos($this->status, 'concluido')===0 || strpos($this->status, 'concluído')===0 ){
            return '<span class="label label-success">Concluído</span>';
        }elseif(strpos($this->status, 'cancelado')===0){
            return '<span class="label label-danger">Cancelado</span>';
        }elseif(strpos($this->status, 'pedido_inicial')===0){
            return '<span class="label label-info">Em análise</span>';
        }elseif(strpos($this->status, 'viabilidade')===0){
            return '<span class="label label-info">Viabilidade</span>';
        }elseif(strpos($this->status, 'dbe')===0){
            return '<span class="label label-info">DBE</span>';
        }elseif(strpos($this->status, 'requerimento')===0){
            return '<span class="label label-info">Requerimento</span>';
        }elseif(strpos($this->status, 'alvara')===0){
            return '<span class="label label-info">Alvará</span>';
        }
        return 'pendente';
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '!=', $this->usuario->id)->count();
    }

    public function getQtdeMensagensNaoLidasAdmin()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('from_admin', 0)->count();
    }

    public function calculaValorAlteracao()
    {
        $ids = $this->tipos()->pluck('id_tipo_alteracao')->toArray();
        $maisCaro = TipoAlteracao::whereIn('id', $ids)->orderBy('valor', 'desc')->first();
        $valor = $maisCaro->valor;
        foreach ($this->tipos as $tipo) {
            $tipo->tipo->id == $maisCaro->id ? $valor += $tipo->tipo->valor : $valor += $tipo->tipo->getValorComDesconto();
        }
        return $valor;
    }
    public static function calculaValorAlteracaoAjax($ids)
    {
        $maisCaro = TipoAlteracao::whereIn('id', $ids)->orderBy('valor', 'desc')->first();
        $tipos = TipoAlteracao::whereIn('id', $ids)->get();
        $valor = $maisCaro->valor;
        foreach ($tipos as $tipo) {
            $tipo->id == $maisCaro->id ? $valor += $tipo->valor : $valor += $tipo->getValorComDesconto();
        }
        return $valor;
    }

}
