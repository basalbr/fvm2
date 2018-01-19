<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

/**
 * @property integer id
 * @property string descricao
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 */
class IrDependente extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ir_dependente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_imposto_renda', 'id_ir_tipo_dependente', 'nome', 'data_nascimento'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function imposto_renda()
    {
        return $this->belongsTo(ImpostoRenda::class, 'id_imposto_renda');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoDependencia::class, 'id_ir_tipo_dependente');
    }

}