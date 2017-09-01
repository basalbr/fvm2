<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class TipoAlteracaoContratual extends Model {

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_alteracao_contratual';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao','valor'];

    public function alteracoes(){
        return $this->hasMany(AlteracaoContratual::class,'id_tipo_alteracao_contratual','id');
    }

}
