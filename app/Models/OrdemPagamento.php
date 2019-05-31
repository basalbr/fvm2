<?php

namespace App\Models;

use Exception;
use function GuzzleHttp\Psr7\str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;
use PagSeguro\Configuration\Configure;
use PagSeguro\Domains\Requests\Payment;
use PagSeguro\Library;
use PagSeguro\Services\Session;

class OrdemPagamento extends Model
{

    use SoftDeletes;


    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'vencimento'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ordem_pagamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['referencia', 'id_referencia', 'vencimento', 'status', 'valor', 'id_usuario'];

    public function isPending()
    {
        if ($this->status == 'Cancelada' || $this->status == 'Pendente' || $this->status == 'Aguardando pagamento') {
            return true;
        }
        return false;
    }

    public function delete(){
        if($this->historico_pagamentos->count()){
            foreach ($this->historico_pagamentos as $historico_pagamento){
                $historico_pagamento->delete();
            }
        }
        parent::delete();
    }

    public function getStatusAttribute($status){
        return $status == 'Cancelada' ? 'Pendente' : $status;
    }

    public function getBotaoPagamento()
    {

        try {
            $nome = str_word_count($this->usuario->nome) > 1 ? $this->usuario->nome : 'Usuário: ' . $this->usuario->nome;

            $payment = new Payment();
            $payment->addItems()->withParameters(
                $this->id_referencia,
                $this->getDescricao(),
                1,
                $this->valor
            );
            $payment->setCurrency("BRL");
            $payment->setReference($this->id);
            $payment->setRedirectUrl(route('listOrdensPagamentoToUser'));
            $payment->setNotificationUrl(Config::getPagseguroNotificationUrl());
            $payment->setSender()->setName(str_limit($nome, 25));
            $payment->setSender()->setEmail($this->usuario->email);
            $result = $payment->register(Configure::getAccountCredentials());
            return $result;
        } catch (Exception $e) {
            Log::critical($e);
        }
        return '';
    }

    public function getLabelStatus(){
        if(strpos($this->status, ucfirst('pendente'))===0){
            return '<span class="label label-danger">Pendente</span>';
        }elseif(strpos($this->status, ucfirst('aguardando pagamento'))===0){
            return '<span class="label label-warning">Aguardando Pagamento</span>';
        }elseif(strpos($this->status, ucfirst('paga'))===0 || strpos($this->status, ucfirst('disponível'))===0){
            return '<span class="label label-success">Paga</span>';
        }elseif(strpos($this->status, ucfirst('cancelada'))===0){
            return '<span class="label label-danger">Cancelada</span>';
        }
        return 'pendente';
    }

    public function formattedValue()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function historico_pagamentos()
    {
        return $this->hasMany(HistoricoPagamento::class, 'id_ordem_pagamento');
    }

    public function getDescricao()
    {
        switch ($this->referencia) {
            case 'abertura_empresa':
                return 'Abertura de Empresa';
                break;
            case 'mensalidade':
                return "Mensalidade";
                break;
            case 'alteracao':
                return Alteracao::findOrFail($this->id_referencia)->getDescricao();
                break;
            default:
                return 'Pagamento';
                break;
        }
    }

    public function parent()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\' . studly_case(str_singular($this->referencia)), 'id_referencia');
    }

    public function getParentName()
    {
        switch ($this->referencia) {
            case 'abertura_empresa':
                return $this->parent ? $this->parent->nome_empresarial1 : $this->id;
            case 'mensalidade':
                return $this->parent->empresa->nome_fantasia.' ('.$this->parent->empresa->razao_social.')';
            case 'alteracao':
                Log::info('AQUIIII'.$this->id);
                return $this->parent->tipo->descricao;
            default:
                return '';
        }
    }

}
