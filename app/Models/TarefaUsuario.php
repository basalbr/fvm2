<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FuncionarioContrato
 * @package App\Models
 */
class TarefaUsuario extends Model
{

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tarefa_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tarefa',
        'id_usuario',
        'funcao',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

}