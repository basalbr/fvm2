<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Apuracao extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'competencia', 'vencimento'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'apuracao';

    protected static $status = ['informacoes_enviadas'=>'Informações Enviadas', 'cancelado'=>'Cancelado', 'em_analise' => 'Em Análise', 'aprovado' => 'Aprovado', 'novo' => 'Novo', 'atencao' => 'Atenção', 'concluido'=>'Concluído', 'sem_movimento'=>'Sem movimento'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'competencia', 'id_imposto', 'vencimento', 'status', 'guia', 'qtde_notas_servico','qtde_notas_entrada','qtde_notas_saida', 'has_retencao_saida', 'has_retencao_entrada'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


    public function isPendingInfo()
    {
        return in_array($this->status, ['Novo', 'Atenção']);
    }

    public function imposto()
    {
        return $this->belongsTo(Imposto::class, 'id_imposto');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getStatusAttribute($status)
    {
        return self::$status[$status];
    }

    public function informacoes()
    {
        return $this->hasMany(ApuracaoInformacaoExtra::class, 'id_apuracao');
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->empresa->usuario->id)->count();
    }

    public function getUltimaMensagem(){
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

    public function getLabelStatus(){
        if(strpos($this->getOriginal('status'), 'informacoes_enviadas')===0){
            if(Auth::user()->is_admin){
                return '<span class="label label-warning fadeIn infinite animated">Aguardando apuração</span>';
            }
            return '<span class="label label-info fadeIn animated">Estamos processando</span>';
        }elseif(strpos($this->getOriginal('status'), 'concluido')===0 || strpos($this->status, 'concluído')===0 ){
            return '<span class="label label-success flash animated">Concluído</span>';
        }elseif(strpos($this->getOriginal('status'), 'cancelado')===0){
            return '<span class="label label-danger fadeIn infinite animated">Cancelado</span>';
        }elseif(strpos($this->getOriginal('status'), 'em_analise')===0){
            return '<span class="label label-info fadeIn infinite animated">Em análise</span>';
        }elseif(strpos($this->getOriginal('status'), 'novo')===0){
            if(Auth::user()->is_admin){
                return '<span class="label label-info">Novo</span>';
            }
            return '<span class="label label-warning fadeIn infinite animated">Envie seus documentos</span>';
        }elseif(strpos($this->getOriginal('status'), 'atencao')===0){
            return '<span class="label label-warning fadeIn infinite animated">Aguardando usuário</span>';
        }elseif(strpos($this->getOriginal('status'), 'sem_movimento')===0){
            return '<span class="label label-success flash animated">Sem movimento</span>';
        }
        return '<span class="label label-info">Novo</span>';
    }


}
