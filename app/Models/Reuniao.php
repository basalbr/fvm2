<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

/**
 * @property integer id
 * @property integer id_usuario
 * @property integer id_horario_reuniao
 * @property string assunto
 * @property string status
 * @property \DateTime data
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 * @property Usuario usuario
 * @property ReuniaoHorario horario
 */
class Reuniao extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reuniao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'id_reuniao_horario', 'status', 'assunto', 'data'];

    protected $status_processo = [
        'em_analise' => 'Estamos analisando a possibilidade da realização da reunião para conversar sobre o assunto na data solicitada',
        'data_invalida' => 'Não é possível marcar uma reunião na data escolhida, por gentileza escolha outra data',
        'cancelado' => 'Essa reunião foi cancelada',
        'aprovado' => 'Essa solicitação foi aprovada',
        'aguardando_usuario' => 'Precisamos que você verifique as mensagens para que possamos concluir a análise da solicitação',
        'concluido' => 'Essa reunião encontra-se finalizada',
    ];

    public function getStatusAttribute($status){
        return strtolower($status);
    }

public function getStatus(){
return $this->status_processo[$this->status];
}

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }


    public function horario()
    {
        return $this->belongsTo(ReuniaoHorario::class, 'id_reuniao_horario');
    }


    public function getUltimaMensagem()
    {
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function pagamento()
    {
        return $this->hasOne(OrdemPagamento::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getLabelMensagensNaoLidasAdmin(){
        return $this->getQtdeMensagensNaoLidasAdmin() > 0 ?
            ' <span class="label label-warning">'.$this->getQtdeMensagensNaoLidasAdmin() . ($this->getQtdeMensagensNaoLidasAdmin() == 1 ? ' mensagem não lida' : ' mensagens não lidas').'</td></span>' : '';
    }

    public function getLabelStatus(){
        if(strpos($this->status, 'em_analise')===0){
            return '<span class="label label-info">Em análise</span>';
        }elseif(strpos($this->status, 'concluido')===0 || strpos($this->status, 'concluído')===0 ){
            return '<span class="label label-success">Concluído</span>';
        }elseif(strpos($this->status, 'cancelado')===0){
            return '<span class="label label-danger">Cancelado</span>';
        }elseif(strpos($this->status, 'aguardando_usuario')===0){
            return '<span class="label label-warning">Aguardando informações</span>';
        }elseif(strpos($this->status, 'data_invalida')===0){
            return '<span class="label label-warning">Escolha outra data</span>';
        }elseif(strpos($this->status, 'aprovado')===0){
            return '<span class="label label-primary">Aprovada</span>';
        }
        return 'pendente';
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '!=', $this->usuario->id)->count();
    }

    public function getQtdeMensagensNaoLidasAdmin()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('from_admin', 0)->count();
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function quantoFalta(){
        $qtde = $this->data->diffInDays(Carbon::now());
        return $qtde > 1 ? 'Em '.$qtde.' dias' : 'Em '.$qtde.' dia';
    }

}
