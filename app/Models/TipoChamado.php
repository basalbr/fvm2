<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

/**
 * Class EnquadramentoEmpresa
 * @package App\Models
 */
class TipoChamado extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_chamado';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao'];

}
