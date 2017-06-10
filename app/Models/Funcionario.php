<?php

namespace App\Models;

use App\Notificacao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends Model
{

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'funcionario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function deficiencias()
    {
        return $this->belongsToMany(FuncionarioDeficiencia::class, (new FuncionarioDeficiencia())->getTable(), 'id_funcionario', 'id_tipo_deficiencia');
    }

    public function dependentes()
    {
        return $this->hasMany(FuncionarioDependente::class, 'id_funcionario');
    }

    public function contratos(){
        return $this->hasMany(FuncionarioContrato::class, 'id_funcionario');
    }

}
