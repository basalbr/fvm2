<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ImpostoMes extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto_mes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mes'];

    
    public function imposto(){
        return $this->belongsTo(Imposto::class, 'id_imposto');
    }

}
