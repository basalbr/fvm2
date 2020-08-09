<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarefa extends Model
{

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tarefa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'assunto', 'mensagem', 'status', 'expectativa_conclusao_em', 'conclusao_em'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'expectativa_conclusao_em', 'conclusao_em'];

    public function usuarios()
    {
        return $this->hasMany(TarefaUsuario::class, 'id_tarefa');
    }

    public function criador()
    {
        $usuario = $this->usuarios()->where('funcao', 'criador')->first();
        $criador = Usuario::findOrFail($usuario->id_usuario);
        return $criador;
    }

    public function responsavel()
    {
        $usuario = $this->usuarios()->where('funcao', 'responsavel')->first();
        $responsavel = Usuario::findOrFail($usuario->id_usuario);
        return $responsavel;
    }

    public function getLabelStatus()
    {
        if (strpos($this->getOriginal('status'), 'pendente') === 0) {
            return '<span class="label label-warning fadeIn infinite animated">Pendente</span>';
        } elseif (strpos($this->getOriginal('status'), 'concluido') === 0 || strpos($this->status, 'concluído') === 0) {
            return '<span class="label label-success flash animated">Concluído</span>';
        } elseif (strpos($this->getOriginal('status'), 'cancelado') === 0) {
            return '<span class="label label-danger fadeIn infinite animated">Cancelado</span>';
        } elseif (strpos($this->getOriginal('status'), 'em_execucao') === 0) {
            return '<span class="label label-primary fadeIn animated">Em execução</span>';
        }
        return '<span class="label label-warning fadeIn infinite animated">Pendente</span>';
    }

    public function getWarnings()
    {
        $today = Carbon::now();
        if(!in_array($this->status, ['pendente', 'em_execucao'])){
            return false;
        }
        $rtn = '';
        $minutos_restantes = $today->diffInMinutes($this->expectativa_conclusao_em);
        if ($minutos_restantes <= 240 and $minutos_restantes > 0) {
            $rtn .= "<span class='label label-danger fadeIn infinite animated'>Essa tarefa irá expirar em " . $minutos_restantes . " minutos</span>";
        }
        if($today > $this->expectativa_conclusao_em){
            $rtn .= "<span class='label label-danger fadeIn infinite animated'>Essa tarefa expirou e você já deveria ter concluído ela</span>";
        }
        return $rtn;
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function registros()
    {
        return $this->hasMany(RegistroAtividade::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->empresa->usuario->id)->count();
    }

    public function getUltimaMensagem()
    {
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

    public function getMensagemAttribute($msg)
    {
        $pattern = '@(http(s)?://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
        return preg_replace($pattern, '<a href="http$2://$3" target="_blank">$0</a>', $msg);
    }


}
