<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ImpostoInformacaoExtra extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto_informacao_extra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_imposto', 'tipo', 'nome', 'descricao', 'tamanho_maximo', 'tabela', 'campo'];

    public function extensoes()
    {
        return $this->hasMany(ImpostoInformacaoExtraExtensao::class, 'id_informacao_extra', 'id');
    }

    public function tipo_formatado()
    {
        if ($this->tipo == 'dado_integrado') {
            return 'Dado Integrado';
        }
        if ($this->tipo == 'anexo') {
            return 'Anexo';
        }
        if ($this->tipo == 'informacao_extra') {
            return 'Informação Extra';
        }
    }


}
