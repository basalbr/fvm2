<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProcessoDocumentoContabil extends Model {

    use SoftDeletes;

    protected $errors;
    protected $dates = ['created_at', 'updated_at', 'periodo'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'processo_documento_contabil';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_pessoa', 'periodo', 'status'];

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

    public function status_formatado() {
        switch ($this->status) {
            case 'pendente':
                return 'Pendente';
            case 'documentos_enviados':
                return 'Documentos Enviados';
            case 'sem_movimento':
                return 'Sem Movimento';
            case 'contabilizado':
                return 'Contabilizado';
                break;
        }
    }

    public function errors() {
        return $this->errors;
    }

    public function enviar_novo_status() {
        $usuario = $this->pessoa->usuario;
        try {
            \Illuminate\Support\Facades\Mail::send('emails.novo-status-documento-contabil', ['nome' => $usuario->nome, 'id_processo' => $this->id], function ($m) use($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject("Novo status em envio de documentos contábeis");
            });
            \Illuminate\Support\Facades\Mail::send("emails.novo-status-documento-contabil-admin", ['id_chamado' => $this->id], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject("Novo status em envio de documentos contábeis");
            });
        } catch (\Exception $ex) {
            \Illuminate\Support\Facades\Log::error($ex);
            return true;
        }
    }

    public function pessoa() {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

}
