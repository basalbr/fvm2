<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chat';
    protected $statusNames = ['novo' => 'Novo', 'ativo' => 'Ativo', 'fechado' => 'Fechado'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['assunto', 'nome', 'email', 'status'];

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function getStatus()
    {
        return $this->statusNames[$this->status];
    }

}
