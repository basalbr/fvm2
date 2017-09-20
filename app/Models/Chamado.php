<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamado extends Model {

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chamado';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'status', 'id_tipo_chamado'];


    public function mensagens(){
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function tipoChamado(){
        return $this->belongsTo(TipoChamado::class, 'id_tipo_chamado');
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}
