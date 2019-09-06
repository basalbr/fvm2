<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

/**
 * @property integer id
 * @property string descricao
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 */
class Anexo extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anexo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_referencia', 'referencia', 'descricao', 'arquivo'];

    public function getLinK()
    {
        return '<a download class="download" href="' . asset(public_path() . 'storage/anexos/' . $this->referencia . '/' . $this->id_referencia . '/' . $this->arquivo) . '" title="Clique para fazer download do arquivo">Download</a>';
    }

}
