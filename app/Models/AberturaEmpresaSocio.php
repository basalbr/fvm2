<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

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
class AberturaEmpresaSocio extends Model
{

    use SoftDeletes;

    protected $dates = ['data_nascimento', 'created_at', 'updated_at', 'deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa_socio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_abertura_empresa',
        'nome',
        'nome_mae',
        'nome_pai',
        'principal',
        'data_nascimento',
        'email',
        'telefone',
        'estado_civil',
        'regime_casamento',
        'cpf',
        'rg',
        'nacionalidade',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'numero',
        'complemento',
        'id_uf',
        'municipio',
        'orgao_expedidor',
        'pro_labore',
        'pis',
        'id_regime_casamento'
    ];

    public function isPrincipal()
    {
        return $this->principal ? 'Sim' : 'Não';
    }

    public function setDataNascimentoAttribute($value)
    {
        $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getNomeAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function getNomePaiAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function setProLaboreAttribute($value){
        $this->attributes['pro_labore'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    public function getNomeMaeAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function getNacionalidadeAttribute($attr)
    {
        return ucwords(strtolower($attr));
    }

    public function empresa()
    {
        return $this->belongsTo(AberturaEmpresa::class, 'id_abertura_empresa');
    }

    public function uf()
    {
        return $this->hasOne(Uf::class, 'id', 'id_uf');
    }

    public function regimeCasamento()
    {
        return $this->hasOne(RegimeCasamento::class, 'id', 'id_regime_casamento');
    }

    public function pro_labore_formatado()
    {
        return number_format($this->pro_labore, 2, ',', '.');
    }

    public function getProLaboreFormatado()
    {
        return number_format($this->pro_labore, 2, ',', '.');
    }

}
