<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Anotacao extends Model {

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anotacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mensagem', 'id_usuario', 'referencia','id_referencia'];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function anexo()
    {
        return $this->hasOne(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function parent(){
        return $this->belongsTo(__NAMESPACE__ .'\\'. studly_case(str_singular($this->referencia)), 'id_referencia');
    }


}
