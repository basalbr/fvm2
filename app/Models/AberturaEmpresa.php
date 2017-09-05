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
        'qtde_documento_contabil'
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

    public function getNomeEmpresarial1Attribute($attr){
        return ucwords(strtolower($attr));
    }

    public function getNomeEmpresarial2Attribute($attr){
        return ucwords(strtolower($attr));
    }

    public function getNomeEmpresarial3Attribute($attr){
        return ucwords(strtolower($attr));
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
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia','=',$this->getTable());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}