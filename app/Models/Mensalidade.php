<?php

namespace App\Models;

use App\Notifications\OrdemPagamentoCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Log;

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
    protected $fillable = [
        'id_usuario',
        'id_empresa',
        'valor',
        'qtde_documento_fiscal',
        'qtde_documento_contabil',
        'qtde_pro_labore',
        'qtde_funcionario',
        'status'];

    public function create(array $attributes)
    {
        $attributes['valor'] = $this->calculateMonthlyPayment();
        return tap($this->related->newInstance($attributes), function ($instance) {
            $instance->setAttribute($this->getForeignKeyName(), $this->getParentKey());

            $instance->save();
        });
    }

    public function abrirOrdensPagamento()
    {
        try {
            $dataVencimento = $this->created_at->format('d');
            $pagamento = $this->pagamentos()->orderBy('created_at', 'desc')->first();
            if (!$pagamento instanceof OrdemPagamento) {
                return false;
            }
            $ultimoPagamento = $pagamento->created_at->format('Y-m');
            $date = strtotime("+1 month", strtotime($ultimoPagamento . '-' . $dataVencimento));
            $vencimento = date('Y-m-d', strtotime("+5 days", $date));
            if ((string)date('Y-m') != $ultimoPagamento) {
                if ($this->empresa->status == 'Aprovado' && !$this->empresa->trashed()) {
                    $pagamento = new OrdemPagamento();
                    $pagamento->id_referencia = $this->id;
                    $pagamento->referencia = $this->getTable();
                    $pagamento->status = 'Pendente';
                    $pagamento->valor = $this->valor;
                    $pagamento->vencimento = $vencimento;
                    $pagamento->id_usuario = $this->empresa->usuario->id;
                    $pagamento->save();
                    $this->empresa->usuario->notify(new OrdemPagamentoCreated($pagamento));
                }
            }
            return true;
        } catch (\Exception $ex) {
            Log::critical($ex);
        }
    }

    public static function calculateMonthlyPayment($data)
    {
        $plano = Plano::where('total_documento_fiscal', '>=', $data['qtde_documento_fiscal'])
            ->where('total_documento_contabil', '>=', $data['qtde_documento_contabil'])
            ->where('total_pro_labore', '>=', $data['qtde_pro_labore'])
            ->orderBy('valor', 'asc')
            ->select('valor')
            ->first();
        return $plano->valor + (Config::getFuncionarioIncrementalPrice() * $data['qtde_funcionario']);
    }

    public function pagamentos()
    {
        return $this->hasMany(OrdemPagamento::class, 'id_referencia')->where('referencia',$this->getTable());
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

}
