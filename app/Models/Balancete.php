<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balancete extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'periodo_inicial', 'periodo_final', 'exercicio'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'balancete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'anexo', 'exercicio', 'periodo_inicial', 'periodo_final', 'receitas', 'despesas'];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function getReceitas()
    {
        return $this->receitas ? 'R$ ' . number_format($this->receitas, 2, ',', '.') : 'R$ 0,00';
    }

    public function getDespesas()
    {
        return $this->despesas ? 'R$ ' . number_format($this->despesas, 2, ',', '.') : 'R$ 0,00';
    }

    public function getResultadoPeriodo()
    {
        $this->receitas ? $receitas = $this->receitas : $receitas = 0;
        $this->despesas ? $despesas = $this->despesas : $despesas = 0;
        return $receitas == $despesas ? '<span class="text-muted">R$ 0,00</span>' :
            $receitas > $despesas ? '<span class="text-primary"><strong> R$ ' . number_format($receitas - $despesas, 2, ',', '.') . '</strong></span>'
                : '<span class="text-danger"><strong>(R$ ' . number_format($despesas - $receitas, 2, ',', '.') . ')</strong></span>';
    }

    public function setExercicioAttribute($value)
    {
        $this->attributes['exercicio'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setReceitasAttribute($value)
    {
        $this->attributes['receitas'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    public function setDespesasAttribute($value)
    {
        $this->attributes['despesas'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    public function getPeriodoInicial()
    {
        return $this->periodo_inicial ? $this->periodo_inicial->format('d/m/Y') : $this->exercicio->format('01/m/Y');
    }

    public function getPeriodoFinal()
    {
        return $this->periodo_final ? $this->periodo_final->format('d/m/Y') : $this->exercicio->format('t/m/Y');
    }

}
