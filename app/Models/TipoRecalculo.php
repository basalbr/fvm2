<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoRecalculo extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_recalculo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao', 'valor', 'status'];

    public function getValor()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function recalculos()
    {
        return $this->hasMany(Recalculo::class, 'id_tipo_recalculo');
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

}