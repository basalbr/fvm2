<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroAtividade extends Model {


    protected $dates = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registro_atividade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'referencia', 'id_referencia', 'mensagem'];


}
