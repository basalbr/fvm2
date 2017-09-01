<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FuncionarioDependente extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'funcionario_dependente';
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_nascimento'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id_funcionario',
      'nome',
      'data_nascimento',
      'local_nascimento',
      'cpf',
      'rg',
      'matricula',
      'cartorio',
      'numero_cartorio',
      'numero_folha',
      'numero_dnv',
      'id_tipo_dependencia',
      'orgao_expedidor_rg',
      'numero_livro'
    ];

    public function setDataNascimentoAttribute($value)
    {
        $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function funcionario() {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }

    public function tipo(){
        return $this->belongsTo(TipoDependencia::class, 'id_tipo_dependencia');
    }
}
