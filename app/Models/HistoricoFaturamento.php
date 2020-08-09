<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricoFaturamento extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'competencia'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'historico_faturamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'competencia', 'valor', 'mercado'];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    public function getValorFormatado()
    {
        return number_format($this->valor, 2, ',', '.');
    }

}
