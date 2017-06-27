<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

class Alteracao extends Model
{

    use SoftDeletes;

    protected $rules = ['id_pessoa' => 'required', 'id_tipo_alteracao' => 'required'];
    protected $errors;
    protected $niceNames = ['id_pessoa' => 'Empresa', 'id_tipo_alteracao' => 'Tipo de Alteração'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'id_usuario', 'status', 'id_tipo_alteracao'];

    public function validateMeiMe($data)
    {
        $rules = ['id_pessoa' => 'required', 'titulo_eleitor' => 'required', 'recibo_ir' => 'sometimes'];
        $niceNames = ['id_pessoa' => 'Empresa', 'titulo_eleitor' => 'Título de Eleitor', 'recibo_ir' => 'Número do Recibo do Último Imposto de Renda'];
        return $this->validate($data, $rules, $niceNames);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoAlteracao::class, 'id_tipo_alteracao');
    }

    public function informacoes()
    {
        return $this->hasMany(AlteracaoInformacao::class, 'id_alteracao');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function pagamento()
    {
        return $this->hasOne(OrdemPagamento::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

}
