<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProcessoDocumentoContabil extends Model
{

    use SoftDeletes;

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
    protected $fillable = ['id_empresa', 'periodo', 'status'];


    public function getStatus()
    {
        switch ($this->status) {
            case 'pendente':
                return 'Pendente';
            case 'documentos_enviados':
                return 'Documentos Enviados';
            case 'atencao':
                return 'Atenção';
            case 'sem_movimento':
                return 'Sem Movimento';
            case 'concluido':
                return 'Contabilizado';
                break;
        }
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function isPendingDocs()
    {
        return $this->anexos->count() ? false : true;
    }

    public function isPending(){
        return $this->isPendingDocs() && $this->status !== 'sem_movimento' && $this->status !== 'concluido';
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->empresa->usuario->id)->count();
    }

    public function getUltimaMensagem(){
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

}
