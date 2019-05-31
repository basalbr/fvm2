<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Recalculo extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recalculo';

    protected $statusDescricao = ['novo' => 'Novo', 'cancelado' => 'Cancelado', 'concluido' => 'Concluído'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_tipo_recalculo', 'id_usuario', 'status', 'descricao', 'guia'];

    public function tipo()
    {
        return $this->belongsTo(TipoRecalculo::class, 'id_tipo_recalculo');
    }

    public function pagamento()
    {
        return $this->hasOne(OrdemPagamento::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function qtdeMensagensNaoLidas($admin = false)
    {
        if ($admin) {
            return $this->mensagens()->where('lida', '=', 0)->where('from_admin', '=', 0)->count();
        }
        return $this->mensagens()->where('lida', '=', 0)->where('from_admin', '=', 1)->count();
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getStatus()
    {
        return $this->statusDescricao[$this->status];
    }

    public function getValor()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }
}
