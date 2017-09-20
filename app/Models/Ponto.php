<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Ponto extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'periodo'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ponto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'periodo', 'status'];

    protected $statusNiceNames = ['pendente' => 'Pendente', 'concluido' => 'Concluído', 'informacoes_enviadas' => 'Informações enviadas'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getStatus()
    {
        return $this->statusNiceNames[$this->status];
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
        return $this->mensagens()->where('lida', '=', 0)->where('id_usuario', '=', $this->empresa->usuario->id)->count();
    }

    public function getUltimaMensagem()
    {
        return $this->mensagens()->latest()->first() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem';
    }

    public function isFinished()
    {
        return ProcessoFolha::where('id_empresa', $this->empresa->id)->where('competencia', $this->periodo)->count() ? true : false;
    }

    public function getProcesso(){
        return ProcessoFolha::where('id_empresa', $this->empresa->id)->where('competencia', $this->periodo)->first();
    }

}
