<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class HistoricoPagamento extends Model {

    use SoftDeletes;

    protected $rules = ['id_mensalidade' => 'required', 'status' => 'required', 'vencimento' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'historico_pagamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['transaction_id', 'status', 'id_ordem_pagamento','forma_pagamento'];


}
