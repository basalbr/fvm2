<?php

namespace App\Models;

use Exception;
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


    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
    protected $fillable = ['referencia', 'id_referencia', 'vencimento', 'status', 'valor'];

    public function isPending()
    {
        if ($this->status == 'Cancelado' || $this->status == 'Pendente' || $this->status == 'Aguardando pagamento') {
            return true;
        }
        return false;
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
            $payment->setNotificationUrl(Config::getPagseguroNotificationUrl());
            $payment->setSender()->setName($nome);
            $payment->setSender()->setEmail($this->usuario->email);
            $result = $payment->register(Configure::getAccountCredentials());
            return $result;
        } catch (Exception $e) {
            Log::critical($e);
        }
        return '';
    }

    public function formattedValue()
    {
        return 'R$' . number_format($this->valor, 2, ',', '.');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function historico_pagamentos()
    {
        return $this->hasMany('App\Pagamento', 'id_mensalidade');
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
                return Alteracao::find($this->id_referencia)->tipo->descricao;
                break;
            default:
                return 'Pagamento';
                break;
        }
    }

}
