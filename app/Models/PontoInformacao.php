<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PontoInformacao extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ponto_informacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_ponto','id_funcionario', 'nome', 'descricao'];

    public function ponto()
    {
        return $this->belongsTo(Ponto::class, 'id_ponto');
    }

    public function funcionario()
    {
        return $this->belongsTo(Ponto::class, 'id_ponto');
    }

}
