<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FuncionarioContrato
 * @package App\Models
 */
class FuncionarioContrato extends Model
{

    use SoftDeletes;


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
        'competencia_sindicato',
        'data_admissao',
        'valor_vale_transporte',
        'desconto_assistencia_medica',
        'salario',
        'desconta_vale_transporte',
        'contrato_experiencia',
        'professor',
        'primeiro_emprego',
        'qtde_dias_experiencia',
        'vale_transporte',
        'id_vinculo_empregaticio',
        'id_categoria_contrato_trabalho',
        'id_situacao_seguro_desemprego',
        'banco_horas',
        'experiencia',
        'qtde_dias_prorrogacao_experiencia'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_admissao', 'competencia_sindicato'];

    public function setCompetenciaSindicatoAttribute($value)
    {
        $this->attributes['competencia_sindicato'] = Carbon::createFromFormat('d/m/Y', $value);
    }
    public function setDataAdmissaoAttribute($value)
    {
        $this->attributes['data_admissao'] = Carbon::createFromFormat('d/m/Y', $value);
    }
    public function setDescontoAssistenciaMedicaAttribute($value){
        $this->attributes['desconto_assistencia_medica'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }
    public function setValorValeTransporteAttribute($value){
        $this->attributes['valor_vale_transporte'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }
    public function setSalarioAttribute($value){
        $this->attributes['salario'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarios()
    {
        return $this->hasMany(FuncionarioDiaTrabalho::class, 'id_funcionario_contrato');
    }

}
