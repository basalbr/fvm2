<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Chamado extends Model {

    use SoftDeletes;

    protected $rules = ['titulo' => 'required', 'mensagem' => 'required'];
    protected $errors;
    protected $niceNames = ['titulo' => 'Título', 'mensagem' => 'Mensagem'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chamado';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'status', 'id_tipo_chamado'];

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

    public function enviar_notificacao_novo_chamado() {
        $usuario = $this->usuario;
        try {
            \Illuminate\Support\Facades\Mail::send('emails.novo-chamado', ['nome' => $usuario->nome, 'id_chamado' => $this->id], function ($m) use($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Novo Chamado');
            });
            \Illuminate\Support\Facades\Mail::send('emails.novo-chamado-admin', ['nome' => $usuario->nome, 'id_chamado' => $this->id], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Novo Chamado');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function errors() {
        return $this->errors;
    }

    public function chamado_respostas() {
        return $this->hasMany('App\ChamadoResposta', 'id_chamado');
    }

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}
