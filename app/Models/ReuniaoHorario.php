<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReuniaoHorario extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reuniao_horario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status', 'hora_inicial', 'hora_final', 'status'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function getHoraInicialAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getHoraFinalAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function reunioes(){
        return $this->hasMany(Reuniao::class, 'id_reuniao_horario');
    }


}
