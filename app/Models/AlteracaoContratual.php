<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

/**
 * @property integer id
 * @property integer id_funcionario
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 * @property Funcionario funcionario
 * @property Uf uf
 * @property RegimeCasamento regimeCasamento
 * @property Cnae cnae
 */
class AlteracaoContratual extends Model
{

    use SoftDeletes;


    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }


    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_alteracao'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao_contratual';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_funcionario', 'id_tipo_alteracao_contratual', 'salario', 'dsr', 'motivo', 'data_alteracao', 'status'];
    protected $statusNiceNames = ['pendente' => 'Pendente', 'concluido' => 'Concluído', 'informacoes_enviadas' => 'Informações enviadas'];

    public function getStatus()
    {
        return $this->statusNiceNames[$this->status];
    }

    public function tipo()
    {
        return $this->belongsTo(TipoAlteracaoContratual::class, 'id_tipo_alteracao_contratual');
    }

    public function getSalario(){
        return number_format($this->salario, 2, ',', '.');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario', 'id');
    }

    public function setSalarioAttribute($value)
    {
        if ($value) {
            $this->attributes['salario'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
        }
    }

    public function setDataAlteracaoAttribute($value)
    {
        $this->attributes['data_alteracao'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarios()
    {
        return $this->hasMany(AlteracaoContratualHorario::class, 'id_alteracao_contratual', 'id');
    }


}
