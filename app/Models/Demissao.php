<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property integer id_funcionario
 * @property integer id_tipo_demissao
 * @property integer id_tipo_aviso_previo
 * @property string observacoes
 * @property string status
 * @property \DateTime data_demissao
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 * @property Funcionario funcionario
 */
class Demissao extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_demissao'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'demissao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_funcionario', 'id_tipo_demissao', 'id_tipo_aviso_previo', 'observacoes', 'data_demissao', 'status'];
    protected $statusNiceNames = ['pendente' => 'Pendente', 'concluido' => 'Concluído', 'informacoes_enviadas' => 'Informações enviadas'];
    public function setDataDemissaoAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['data_demissao'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }
    public function getStatus()
    {
        return $this->statusNiceNames[$this->status];
    }
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }

    public function getUltimaMensagem(){
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getQtdeMensagensNaoLidas()
    {
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->usuario->id)->count();
    }

}
