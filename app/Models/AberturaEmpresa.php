<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 15/03/2017
 * Time: 21:29
 */

namespace App\Models;

use App\Validation\ValidatesAberturaEmpresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AberturaEmpresa extends Model
{
    /**
     * Use Soft Deletes trait
     */
    use SoftDeletes, ValidatesAberturaEmpresa;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'nome_empresarial1',
        'nome_empresarial2',
        'nome_empresarial3',
        'enquadramento',
        'capital_social',
        'id_natureza_juridica',
        'id_tipo_tributacao',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'numero',
        'complemento',
        'id_uf',
        'iptu',
        'area_total',
        'area_ocupada',
        'cpf_cnpj_proprietario',
        'status',
    ];

    public function isSimplesNacional()
    {
        if ($this->cnaes()->where('id_tabela_simples_nacional', '=', null)->count()) {
            return false;
        }
        return true;

    }

    /**
     * Validate and save a new model and return the instance.
     *
     * @param  array $attributes
     * @return AberturaEmpresa | bool
     */
    public static function create(array $attributes = [])
    {
        $model = new static($attributes);
        if ($model->validate($attributes)) {
            $model->save();
            return $model;
        }
        return false;
    }

    public function cnaes()
    {
        return $this->hasMany(AberturaEmpresaCnae::class, 'id_abertura_empresa');
    }

    public function uf()
    {
        return $this->belongsTo(Uf::class, 'id', 'id_uf');
    }

    public function ordemPagamento()
    {
        return $this->hasOne(OrdemPagamento::class, 'id_abertura_empresa');
    }

    public function naturezaJuridica()
    {
        return $this->belongsTo(NaturezaJuridica::class, 'id', 'id_natureza_juridica');
    }

    public function socios()
    {
        return $this->hasMany(AberturaEmpresaSocio::class, 'id_abertura_empresa');
    }

    public function mensagens()
    {
        return $this->hasMany(AberturaEmpresaComentario::class, 'id_abertura_empresa');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function botao_pagamento()
    {
        if (
            ($this->status == 'Atenção' ||
                $this->status == 'Em Processamento' ||
                $this->status == 'Novo') &&
            ($this->pagamento->status == 'Devolvida' ||
                $this->pagamento->status == 'Cancelada' ||
                $this->pagamento->status == 'Pendente' ||
                $this->pagamento->status == 'Aguardando pagamento')
        ) {
            $data = [
                'items' => [
                    [
                        'id' => $this->id,
                        'description' => 'Abertura de Empresa',
                        'quantity' => '1',
                        'amount' => $this->pagamento->valor,
                    ],
                ],
                'notificationURL' => 'http://www.webcontabilidade.com/pagseguro',
                'reference' => $this->pagamento->id,
                'sender' => [
                    'email' => $this->usuario->email,
                    'name' => $this->usuario->nome,
                    'phone' => $this->usuario->telefone
                ]
            ];
            $checkout = Pagseguro::checkout()->createFromArray($data);
            $credentials = PagSeguro::credentials()->get();
            $information = $checkout->send($credentials); // Retorna um objeto de laravel\pagseguro\Checkout\Information\Information
            return '<a href="' . $information->getLink() . '" class="btn btn-success"><span class="fa fa-credit-card"></span> Clique para pagar</a>';
        }
        if ($this->status == 'Disponível' || $this->status == 'Em análise') {
            return '<a href="" class="btn btn-success" disabled>Em processamento</a>';
        }
        return null;
    }
}