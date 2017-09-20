<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Prolabore extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pro_labore';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_socio', 'inss', 'irrf', 'pro_labore', 'valor_pro_labore', 'competencia'];
    protected $dates = ['created_at', 'updated_at', 'competencia'];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getProLaboreFormatado()
    {
        return number_format($this->valor_pro_labore, 2, ',', '.');
    }

}
