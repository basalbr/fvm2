<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use App\Auth;
/**
 * @property integer id
 * @property integer id_abertura_empresa
 * @property integer id_cnae
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property AberturaEmpresa empresa
 * @property Cnae cnae
 */
class AberturaEmpresaCnae extends Model {



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa_cnae';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_abertura_empresa', 'id_cnae'];

    public function empresa(){
        return $this->belongsTo(AberturaEmpresa::class, 'id_abertura_empresa');
    }
    
    public function cnae(){
        return $this->belongsTo(Cnae::class, 'id_cnae');
    }

}
