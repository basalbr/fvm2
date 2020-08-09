<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tributacao extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tributacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'descricao', 'mercado', 'id_tabela_simples_nacional'];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function isencao()
    {
        return $this->hasMany(TributacaoIsencao::class, 'id_tributacao');
    }

    public function impostos_isentos()
    {
        $impostos = [];
        foreach ($this->isencao as $isencao) {
            $imposto = ImpostoFaixaSimplesNacional::find($isencao->id_imposto_faixa_simples_nacional);
            if (!in_array($imposto->descricao, $impostos)) {
                $impostos[] = $imposto->descricao;
            }
        }
        return $impostos;
    }

    public function hasIsencao($isencao)
    {
       $impostos = $this->impostos_isentos();
       if(in_array($isencao, $impostos)){
           return true;
       }
        return false;
    }


    public function tabelaSimplesNacional()
    {
        return $this->belongsTo(TabelaSimplesNacional::class, 'id_tabela_simples_nacional');
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    public function getValorFormatado()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function getMercadoLabel(){
        return $this->mercado == 'interno' ? '<span class="label label-info">Mercado Interno</span>' : '<span class="label label-warning">Mercado Externo</span>';

    }

}
