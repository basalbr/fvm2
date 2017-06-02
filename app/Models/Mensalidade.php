<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Mensalidade extends Model
{

    use SoftDeletes;

    protected $rules = ['id_usuario' => 'required', 'id_pessoa' => 'required', 'duracao' => 'required', 'valor' => 'required|numeric', 'tipo' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mensalidade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'id_pessoa', 'valor', 'duracao', 'documentos_fiscais', 'documentos_contabeis', 'pro_labores', 'funcionarios', 'status', 'created_at'];


    public function calculateMonthlyPayment()
    {
        $plano = Plano::where('total_documento_fiscal', '<=', $this->qtde_documentos_fiscais)
            ->where('total_documento_contabil', '<=', $this->qtde_documentos_contabeis)
            ->where('total_pro_labore', '<=', $this->qtde_pro_labores)->select('valor')->first();
        return $plano->valor + (Config::getFuncionarioIncrementalPrice() * $this->qtde_funcionarios);
    }

    public function pagamentos()
    {
        return $this->hasMany('App\Pagamento', 'id_mensalidade');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

}
