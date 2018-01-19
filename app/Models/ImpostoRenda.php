<?php

namespace App\Models;

use App\Notifications\NewApuracao;
use App\Notifications\NewProcessoDocumentosContabeis;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/* @property Usuario usuario */

class ImpostoRenda extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto_renda';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'exercicio',
        'status',
        'recibo_anterior',
        'declaracao_anterior',
        'recibo',
        'declaracao'
    ];

    protected static $status = ['em_analise' => 'Em Análise', 'aguardando_conclusao' => 'Aguardando envio dos documentos','cancelado'=>'Cancelado', 'concluido'=>'Concluído'];


    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }



    public function getUltimaMensagem()
    {
        return $this->mensagens->count() ? $this->mensagens()->latest()->first()->mensagem : 'Nenhuma mensagem encontrada';
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function declarante()
    {
        return $this->hasOne(IrDeclarante::class, 'id_imposto_renda');
    }

    public function dependentes(){
        return $this->hasMany(IrDependente::class, 'id_imposto_renda');
    }

    public function delete()
    {

        if ($this->apuracoes->count()) {
            foreach ($this->apuracoes as $processo) {
                $processo->delete();
            }
        }
        if ($this->processosDocumentosContabeis()->count()) {
            foreach ($this->processos_documentos_contabeis as $processo) {
                $processo->delete();
            }
        }

        if ($this->funcionarios->count()) {
            foreach ($this->funcionarios as $funcionario) {
                $funcionario->delete();
            }
        }

        if ($this->socios->count()) {
            foreach ($this->socios as $socio) {
                $socio->delete();
            }
        }

        parent::delete();
    }


    public function getQtdMensagensNaoLidas($isAdmin = false){
        if($isAdmin){
            return $this->mensagens()->where('from_admin', 1)->where('lida', 0)->count();
        }
        return $this->mensagens()->where('from_admin', 0)->where('lida', 0)->count();
    }

}
