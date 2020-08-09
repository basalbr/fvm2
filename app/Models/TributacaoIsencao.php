<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class TributacaoIsencao extends Model
{

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tributacao_isencao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_tributacao', 'id_imposto_faixa_simples_nacional'];

    public function tributacao()
    {
        return $this->belongsTo(Tributacao::class, 'id_tributacao');
    }
    public function imposto()
    {
        return $this->belongsTo(ImpostoFaixaSimplesNacional::class, 'id_imposto_faixa_simples_nacional');
    }

}
