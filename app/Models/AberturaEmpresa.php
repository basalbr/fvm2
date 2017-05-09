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

    public function isSimplesNacional()
    {
        if ($this->cnaes()->where('id_tabela_simples_nacional', '=', null)->count()) {
            return false;
        }
        return true;

    }

    /**
     * @return AberturaEmpresaSocio
     */
    public function getSocioPrincipal()
    {
        return $this->socios()->where('principal', '=', 1)->first();
    }

    public function getPaymentStatus()
    {
        return OrdemPagamento::where('referencia', '=', $this->getTable())->where('id_referencia', '=', $this->id)->first()->status;
    }

    public function getMonthlyPayment()
    {
        $qtdeProLabore = $this->socios()->where('pro_labore', '>', 0)->count();
        return 'R$ '.number_format(
            CalculateMonthlyPayment::handle($this->qtde_funcionario, $this->qtde_documento_fiscal, $this->qtde_documento_contabil, $qtdeProLabore),
            2,
            ',',
            '.'
        );
    }

    public function cnaes()
    {
        return $this->hasMany(AberturaEmpresaCnae::class, 'id_abertura_empresa');
    }

    public function uf()
    {
        return $this->belongsTo(Uf::class, 'id', 'id_uf');
    }

    public function ordemPagamento()
    {
        return OrdemPagamento::where('referencia','=', $this->getTable())->where('id_referencia','=',$this->id)->first();
    }

    public function naturezaJuridica()
    {
        return $this->belongsTo(NaturezaJuridica::class, 'id', 'id_natureza_juridica');
    }

    public function socios()
    {
        return $this->hasMany(AberturaEmpresaSocio::class, 'id_abertura_empresa');
    }

    public function mensagens()
    {
        return $this->hasMany(AberturaEmpresaComentario::class, 'id_abertura_empresa');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}