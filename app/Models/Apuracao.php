<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    protected static $status = ['em_analise' => 'Em Análise', 'aprovado'=>'Aprovado', 'novo'=>'Novo', 'atencao'=>'Atenção'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'competencia', 'id_imposto', 'vencimento', 'status', 'guia'];

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function imposto(){
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
    public function informacoes(){
        return $this->hasMany(ApuracaoInformacaoExtra::class, 'id_apuracao');
    }


}
