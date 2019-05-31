<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoAlteracao extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_alteracao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao', 'valor', 'valor_desconto_progressivo', 'tipo_desconto_progressivo'];

    protected $descricaoDescontoProgressivo = ['percentual' => 'Percentual', 'fixo' => 'Fixo'];

    public function getValor()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function getCamposAtivos()
    {
        return $this->campos()->where('ativo', 1)->get();
    }

    public function getValorDescontoProgressivo()
    {
        return number_format($this->valor_desconto_progressivo, 2, ',', '.');
    }

    public function getTipoDescontoProgressivo()
    {
        return $this->descricaoDescontoProgressivo[$this->tipo_desconto_progressivo];
    }

    public function getValorComDesconto(): float
    {
        return $this->tipo_desconto_progressivo == 'fixo' ? $this->valor - $this->valor_desconto_progressivo : $this->valor - ($this->valor * ($this->valor_desconto_progressivo / 100));
    }

    public function getValorComDescontoFormatado(): string
    {
        return number_format($this->getValorComDesconto(), 2, ',', '.');
    }


    public function campos()
    {
        return $this->hasMany(AlteracaoCampo::class, 'id_tipo_alteracao');
    }


    public function alteracoes()
    {
        return $this->hasMany(Alteracao::class, 'id_tipo_alteracao');
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    public function setValorDescontoProgressivoAttribute($value)
    {
        $this->attributes['valor_desconto_progressivo'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }
}
