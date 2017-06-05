<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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
    protected $fillable = ['id_usuario', 'id_empresa', 'valor', 'qtde_documentos_fiscais', 'qtde_documentos_contabeis', 'qtde_pro_labores', 'qtde_funcionarios', 'status'];

    public function create(array $attributes)
    {
        $attributes['valor'] = $this->calculateMonthlyPayment();
        return tap($this->related->newInstance($attributes), function ($instance) {
            $instance->setAttribute($this->getForeignKeyName(), $this->getParentKey());

            $instance->save();
        });
    }

    public static function calculateMonthlyPayment($data)
    {
        $plano = Plano::where('total_documento_fiscal', '>=', $data['qtde_documento_fiscal'])
            ->where('total_documento_contabil', '>=', $data['qtde_documento_contabil'])
            ->where('total_pro_labore', '>=', $data['qtde_pro_labores'])
            ->orderBy('valor', 'asc')
            ->select('valor')
            ->first();
        return $plano->valor + (Config::getFuncionarioIncrementalPrice() * $data['qtde_funcionario']);
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
