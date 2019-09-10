<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Socio extends Model {

    use SoftDeletes;


    protected $errors;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'socio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pessoa',
        'municipio',
        'nome',
        'nome_mae',
        'nome_pai',
        'pis',
        'principal',
        'cpf',
        'rg',
        'titulo_eleitor',
        'recibo_ir',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'id_uf',
        'pro_labore',
        'orgao_expedidor',
        'telefone',
        'data_nascimento',
        'email',
        'nacionalidade',
        'estado_civil',
        'id_regime_casamento',
        'numero',
        'complemento'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_nascimento'];

    public function setDataNascimentoAttribute($value)
    {
        $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setProLaboreAttribute($value){
        $this->attributes['pro_labore'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    public function errors() {
        return $this->errors;
    }

    public function getNomeAttribute($attr){
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function getNomePaiAttribute($attr){
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function getNomeMaeAttribute($attr){
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function getNacionalidadeAttribute($attr){
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    public function uf() {
        return $this->belongsTo(Uf::class, 'id_uf');
    }

    public function pro_labores() {
        return $this->hasMany(Prolabore::class, 'id_socio');
    }

    public function getProLaboreFormatado() {
        return number_format($this->pro_labore, 2, ',', '.');
    }

    public function isPrincipal(){
        return $this->principal ? 'Sim': 'Não';
    }


}
