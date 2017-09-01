<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class AlteracaoContratualHorario extends Model {

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao_contratual_horario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_alteracao_contratual',
        'hora1',
        'hora2',
        'hora3',
        'hora4',
        'dia'
    ];

    public function alteracao() {
        return $this->belongsTo(AlteracaoContratual::class, 'id_alteracao_contratual');
    }

}
