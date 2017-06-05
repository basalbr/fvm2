<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Plano extends Model {

    use SoftDeletes;

    protected $errors;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plano';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['duracao', 'valor', 'nome', 'descricao', 'total_documento_fiscal','total_documento_contabil', 'total_pro_labore', 'total_funcionario'];


}
