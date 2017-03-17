<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ImpostoMes extends Model {


    protected $rules = ['mes' => 'required'];
    protected $errors;
    protected $niceNames = ['mes' => 'Mês'];

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


    public function validate($data) {
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        $v->setAttributeNames($this->niceNames);
        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors()->all();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors() {
        return $this->errors;
    }
    
    public function imposto(){
        return $this->belongsTo('App\Imposto', 'id_imposto');
    }

}
