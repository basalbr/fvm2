<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ProcessoResposta extends Model {

    use SoftDeletes;

    protected $rules = ['mensagem' => 'required', 'id_usuario'=>'required', 'id_processo'=>'required'];
    protected $errors;
    protected $niceNames = ['mensagem' => 'Mensagem'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'processo_resposta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_processo', 'id_usuario', 'anexo', 'mensagem'];

    public function validate($data) {
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        $v->setAttributeNames($this->niceNames);
        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors()->all();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors() {
        return $this->errors;
    }
    
     public function chamado()
    {
        return $this->belongsTo('App\Chamado','id_chamado');
    }
    
     public function usuario()
    {
        return $this->belongsTo('App\Usuario','id_usuario');
    }

}
