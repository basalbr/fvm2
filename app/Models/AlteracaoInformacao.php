<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlteracaoInformacao extends Model {

    use SoftDeletes;

    protected $rules = ['valor' => 'required', 'id_alteracao' => 'required', 'id_alteracao_campo' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'informacao' => 'Informação', 'tipo' => 'Tipo'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao_informacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_alteracao', 'valor', 'id_alteracao_campo'];



    public function errors() {
        return $this->errors;
    }

    public function campo(){
         return $this->belongsTo(AlteracaoCampo::class, 'id_alteracao_campo');
    }
    
    public function alteracao() {
        return $this->belongsTo(Alteracao::class, 'id_alteracao');
    }

}
