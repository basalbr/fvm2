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
    public function getLabelStatus(){
        if(strpos($this->getOriginal('status'), 'documentos_enviados')===0){
            return '<span class="label label-warning fadeIn infinite animated">Aguardando contabilização</span>';
        }elseif(strpos($this->getOriginal('status'), 'concluido')===0 || strpos($this->status, 'concluído')===0 ){
            return '<span class="label label-success flash animated">Concluído</span>';
        }elseif(strpos($this->getOriginal('status'), 'sem_movimento')===0){
            return '<span class="label label-danger fadeIn infinite animated">Sem Movimento</span>';
        }elseif(strpos($this->getOriginal('status'), 'em_analise')===0){
            return '<span class="label label-info fadeIn infinite animated">Em análise</span>';
        }elseif(strpos($this->getOriginal('status'), 'novo')===0){
            return '<span class="label label-info">Novo</span>';
        }elseif(strpos($this->getOriginal('status'), 'atencao')===0){
            return '<span class="label label-warning fadeIn infinite animated">Aguardando usuário</span>';
        }elseif(strpos($this->getOriginal('status'), 'sem_movimento')===0){
            return '<span class="label label-success flash animated">Sem movimento</span>';
        }
        return '<span class="label label-info">Novo</span>';
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
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
        return !in_array($this->status, ['sem_movimento', 'documentos_enviados', 'concluido']);
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
