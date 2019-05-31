<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlteracaoCampo extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao_campo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_tipo_alteracao', 'tipo', 'nome', 'descricao', 'obrigatorio', 'ativo'];

    protected $tipos = ['file' => 'Arquivo', 'textarea' => 'Área de texto', 'string' => 'Campo de texto', 'table' => 'Tabela'];

    public function tipo_alteracao()
    {
        return $this->belongsTo(TipoAlteracao::class, 'id_tipo_alteracao');
    }

    public function getTipoDescricao()
    {
        return $this->tipo == 'table' ? 'Tabela (' . $this->tabela . ', ' . $this->coluna . ')' : $this->tipos[$this->tipo];
    }


}
