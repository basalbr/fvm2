<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

class OrdemPagamento extends Model
{

    use SoftDeletes;

    protected $rules = ['id_mensalidade' => 'required', 'status' => 'required', 'vencimento' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ordem_pagamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['referencia', 'id_referencia', 'vencimento', 'status', 'valor'];

    public function validate($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        $v->setAttributeNames($this->niceNames);
        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors()->all();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function formattedValue()
    {
        return 'R$' . number_format($this->valor, 2, ',', '.');
    }

    public function mensalidade()
    {
        return $this->belongsTo('App\Mensalidade', 'id_mensalidade');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function abertura_empresa()
    {
        return $this->belongsTo('App\AberturaEmpresa', 'id_abertura_empresa');
    }

    public function historico_pagamentos()
    {
        return $this->hasMany('App\Pagamento', 'id_mensalidade');
    }


}
