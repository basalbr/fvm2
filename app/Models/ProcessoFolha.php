<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ProcessoFolha extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'processo_folha';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'inss', 'irrf', 'recibo_folha', 'fgts', 'competencia'];
    protected $dates = ['created_at', 'updated_at', 'competencia'];

    public function delete(){
        if($this->anotacoes->count()){
            foreach ($this->anotacoes as $anotacao){
                $anotacao->delete();
            }
        }
        if($this->mensagens->count()){
            foreach ($this->mensagens as $mensagem){
                $mensagem->delete();
            }
        }
        parent::delete();
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

}
