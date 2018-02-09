<?php

namespace App\Models;

use Carbon\Carbon;
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
class IrDeclarante extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ir_declarante';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_imposto_renda', 'id_ir_tipo_ocupacao', 'nome', 'data_nascimento', 'cpf', 'rg', 'titulo_eleitor', 'ocupacao', 'comprovante_residencia'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_nascimento'];

    public function imposto_renda()
    {
        return $this->belongsTo(ImpostoRenda::class, 'id_imposto_renda');
    }

    public function getDataNascimento(){
        return $this->data_nascimento ? $this->data_nascimento->format('d/m/Y') : null;
    }

    public function setDataNascimentoAttribute($value)
    {
        if ($value) {
            $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

}
