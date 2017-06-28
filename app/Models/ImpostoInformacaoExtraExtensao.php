<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ImpostoInformacaoExtraExtensao extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto_informacao_extra_extensao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_informacao_extra', 'extensao'];


    public function extensoes() {
        return $this->belongsTo(ImpostoInformacaoExtra::class, 'id_informacao_extra','id');
    }

}
