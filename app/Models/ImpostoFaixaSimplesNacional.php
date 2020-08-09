<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ImpostoFaixaSimplesNacional extends Model
{

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto_faixa_simples_nacional';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_faixa_simples_nacional', 'descricao', 'valor'];

    public function faixa_simples_nacional()
    {
        return $this->belongsTo(FaixaSimplesNacional::class, 'id_faixa_simples_nacional');
    }

}
