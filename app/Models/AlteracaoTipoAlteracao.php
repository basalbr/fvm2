<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class AlteracaoTipoAlteracao extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao_tipo_alteracao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_alteracao', 'id_tipo_alteracao'];

    public function tipo()
    {
        return $this->hasOne(TipoAlteracao::class, 'id','id_tipo_alteracao');
    }

}
