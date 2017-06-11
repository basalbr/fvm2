<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FuncionarioDocumento extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'funcionario_documento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_funcionario',
        'nome',
        'descricao',
        'documento'
    ];


    public function funcionario() {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }

}
