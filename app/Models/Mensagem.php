<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Mensagem extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mensagem';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mensagem', 'id_usuario', 'referencia', 'id_referencia', 'from_admin', 'lida'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function anexo()
    {
        return $this->hasOne(Anexo::class, 'id_referencia')->where('referencia', '=', $this->getTable());
    }

    public function parent()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\' . studly_case(str_singular($this->referencia)), 'id_referencia');
    }

    public function targetUser()
    {
        $hasOneAdditionalTable = ['apuracao', 'processo_documento_contabil', 'processo_folha', 'funcionario', 'ponto', 'decimo_terceiro'];
        $hasTwoAdditionalTable = ['demissao', 'alteracao_contratual'];
        Log::info('Mensagem: '.$this->id);
        if (in_array($this->referencia, $hasOneAdditionalTable)) {
            return $this->parent->empresa->usuario;
        }
        if (in_array($this->referencia, $hasTwoAdditionalTable)) {
            return $this->parent->funcionario->empresa->usuario;
        }
        $result = DB::table($this->referencia)->where('id',$this->id_referencia)->first();
        return Usuario::find($result->id_usuario);

    }

    public function getMensagemAttribute($msg){
        $pattern = '@(http(s)?://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
        return preg_replace($pattern, '<a href="http$2://$3" target="_blank">$0</a>', $msg);
    }

}
