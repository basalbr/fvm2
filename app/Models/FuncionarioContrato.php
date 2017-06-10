<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FuncionarioContrato extends Model {

    use SoftDeletes;

    protected $rules = [
    ];
    protected $errors;
    protected $niceNames = [
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'funcionario_contrato';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_funcionario',
        'cargo',
        'funcao',
        'departamento',
        'sindicato',
        'dsr',
        'sindicalizado',
        'pagou_contribuicao',
        'competencia_sindicato',
        'data_admissao',
        'qtde_dias_vale_transporte',
        'valor_vale_transporte',
        'valor_assistencia_medica',
        'desconto_assistencia_medica',
        'vinculo_empregaticio',
        'situacao_seguro_desemprego',
        'salario',
        'possui_banco_de_horas',
        'desconta_vale_transporte',
        'contrato_experiencia',
        'professor',
        'primeiro_emprego',
        'qtde_dias_experiencia',
        'data_inicio_experiencia',
        'data_final_experiencia',
        'data_inicio_prorrogacao_experiencia',
        'data_final_prorrogacao_experiencia',
    ];



    public function funcionario() {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }
    
    public function horarios(){
        return $this->hasMany(FuncionarioDiaTrabalho::class,'id_funcionario_contrato');
    }

}
