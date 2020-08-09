<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FaixaSimplesNacional extends Model
{

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faixa_simples_nacional';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_tabela_simples_nacional', 'descricao', 'de', 'ate', 'aliquota', 'deducao'];

    public function tabela_simples_nacional()
    {
        return $this->belongsTo(TabelaSimplesNacional::class, 'id_tabela_simples_nacional');
    }

}
