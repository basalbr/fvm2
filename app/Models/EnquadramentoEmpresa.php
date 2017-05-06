<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class EnquadramentoEmpresa extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'enquadramento_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao'];

}
