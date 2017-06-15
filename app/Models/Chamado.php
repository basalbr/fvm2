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
        return Mensagem::where('id_referencia','=',$this->id)->where('referencia','=',$this->getTable());
    }

    public function messages()
    {
        return Mensagem::where('id_referencia', '=', $this->id)->where('referencia', '=', $this->getTable())->orderBy('created_at', 'asc')->get();
    }

    public function anexos()
    {
        return Anexo::where('id_referencia', '=', $this->id)->where('referencia', '=', $this->getTable())->orderBy('created_at', 'asc')->get();
    }

    public function tipoChamado(){
        return $this->belongsTo(TipoChamado::class, 'id_tipo_chamado');
    }

}
