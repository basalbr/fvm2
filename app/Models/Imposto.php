<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Imposto extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'vencimento', 'antecipa_posterga', 'recebe_documento'];


    public function meses()
    {
        return $this->hasMany(ImpostoMes::class, 'id_imposto');
    }

    public function instrucoes()
    {
        return $this->hasMany(ImpostoInstrucao::class, 'id_imposto');
    }

    public function informacoesExtras()
    {
        return $this->hasMany(ImpostoInformacaoExtra::class, 'id_imposto');
    }

    public function corrigeData($date, $format)
    {
        $retDate = new \DateTime($date);
        $weekDay = date('w', strtotime($date));
        if ($this->antecipa_posterga == 'posterga') {
            if ($weekDay == 0) {
                $retDate->add(new \DateInterval('P1D'));
            }
            if ($weekDay == 6) {
                $retDate->add(new \DateInterval('P2D'));
            }
        }
        if ($this->antecipa_posterga == 'antecipa') {
            if ($weekDay == 0) {
                $retDate->sub(new \DateInterval('P2D'));
            }
            if ($weekDay == 6) {
                $retDate->sub(new \DateInterval('P1D'));
            }
        }
        return $retDate->format($format);
    }

}
