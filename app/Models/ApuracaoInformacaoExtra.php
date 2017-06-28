<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ApuracaoInformacaoExtra extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'apuracao_informacao_extra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_apuracao', 'id_informacao_extra', 'informacao'];

    public function apuracao(){
        return $this->belongsTo(Apuracao::class, 'id_apuracao');
    }
    
    public function tipo()
    {
        return $this->belongsTo(ImpostoInformacaoExtra::class,'id_informacao_extra');
    }

    public function toAnexo(){
        return (object)['referencia'=>$this->apuracao->getTable(), 'id_referencia'=>$this->apuracao->id, 'arquivo'=>$this->informacao, 'descricao'=>$this->tipo->nome];
    }

}
