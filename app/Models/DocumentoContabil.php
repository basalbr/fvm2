<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DocumentoContabil extends Model {

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documento_contabil';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao', 'anexo', 'id_processo_documento_contabil'];

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


    

    public function errors() {
        return $this->errors;
    }

    public function chamado_respostas() {
        return $this->hasMany('App\ChamadoResposta', 'id_chamado');
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
