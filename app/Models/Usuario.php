<?php

namespace App\Models;

use App\Overrides\Auth\Passwords\CanResetPassword;
use App\Overrides\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Hash;

/**
 * @property boolean admin
 * @property string nome
 * @property string telefone
 * @property string email
 * @property \Datetime created_at
 * @property \Datetime updated_at
 * @property \Datetime deleted_at
 */
class Usuario extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        Notifiable,
        SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'email', 'senha', 'telefone'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['senha', 'remember_token'];

    public static function admins()
    {
        return static::where('admin', '=', true)->get();
    }

    public function delete()
    {
        if ($this->empresas->count()) {
            foreach ($this->empresas as $empresa) {
                $empresa->delete();
            }
        }
        if ($this->aberturasEmpresa->count()) {
            foreach ($this->aberturasEmpresa as $aberturaEmpresa) {
                $aberturaEmpresa->delete();
            }
        }
        if ($this->alteracoes->count()) {
            foreach ($this->alteracoes as $alteracao) {
                $alteracao->delete();
            }
        }
        if ($this->chamados->count()) {
            foreach ($this->chamados as $chamado) {
                $chamado->delete();
            }
        }
        if ($this->impostosRenda->count()) {
            foreach ($this->impostosRenda as $impostoRenda) {
                $impostoRenda->delete();
            }
        }
        if (Mensagem::where('id_usuario', $this->id)->count()) {
            foreach (Mensagem::where('id_usuario', $this->id)->get() as $mensagem) {
                $mensagem->delete();
            }
        }
        if ($this->ordensPagamento->count()) {
            foreach ($this->ordensPagamento as $ordem_pagamento) {
                $ordem_pagamento->delete();
            }
        }
        parent::delete();
    }



    public function errors()
    {
        return $this->errors;
    }

    public function getAuthPassword()
    {
        return $this->attributes['senha'];
    }

    public function chamados()
    {
        return $this->hasMany(Chamado::class, 'id_usuario');
    }

    public function getEmailAttribute($attr)
    {
        return strtolower($attr);
    }

    public function getNomeAttribute($attr)
    {
        return mb_convert_case(strtolower($attr), MB_CASE_TITLE);
    }

    public function demissoes()
    {
        return $this->hasMany(Demissao::class, 'id_usuario');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'id_usuario');
    }

    public function impostosRenda()
    {
        return $this->hasMany(ImpostoRenda::class, 'id_usuario');
    }

    public function alteracoes()
    {
        return $this->hasMany(Alteracao::class, 'id_usuario');
    }

    public function aberturasEmpresa()
    {
        return $this->hasMany(AberturaEmpresa::class, 'id_usuario');
    }

    public function reunioes()
    {
        return $this->hasMany(Reuniao::class, 'id_usuario');
    }

    public function recalculos()
    {
        return $this->hasMany(Recalculo::class, 'id_usuario');
    }

    public function ordensPagamento()
    {
        return $this->hasMany(OrdemPagamento::class, 'id_usuario');
    }

    public function setSenhaAttribute($senha)
    {
        $this->attributes['senha'] = Hash::make($senha);
    }

    public function setNomeAttribute($nome)
    {
        $this->attributes['nome'] = mb_convert_case(strtolower($nome), MB_CASE_TITLE);
    }

    public function getFirstName()
    {
        return array_first(explode(' ', $this->nome));
    }

    public static function notifyAdmins($notification)
    {
        $admins = self::where('admin', '=', 1)->get();
        foreach ($admins as $admin) {
            /** @var Usuario $admin */
            $admin->notify($notification);
        }
    }

    public function funcionarios()
    {
        return $this->hasManyThrough(
            Funcionario::class,
            Empresa::class,
            'id_usuario',
            'id_empresa',
            'id'
        );
    }

    public function socios()
    {
        return $this->hasManyThrough(
            Socio::class,
            Empresa::class,
            'id_usuario',
            'id_empresa',
            'id'
        );
    }

    public function apuracoes()
    {
        return $this->hasManyThrough(
            Apuracao::class,
            Empresa::class,
            'id_usuario',
            'id_empresa',
            'id'
        );
    }

    public function documentosContabeis()
    {
        return $this->hasManyThrough(
            ProcessoDocumentoContabil::class,
            Empresa::class,
            'id_usuario',
            'id_empresa',
            'id'
        );
    }

    public function decimosTerceiro()
    {
        return $this->hasManyThrough(
            DecimoTerceiro::class,
            Empresa::class,
            'id_usuario',
            'id_empresa',
            'id'
        );
    }

    public function balancetes()
    {
        return $this->hasManyThrough(
            Balancete::class,
            Empresa::class,
            'id_usuario',
            'id_empresa',
            'id'
        );
    }


    public function pontos()
    {
        return $this->hasManyThrough(
            Ponto::class,
            Empresa::class,
            'id_usuario',
            'id_empresa',
            'id'
        );
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'notifiable_id')->where('notifiable_type', '=', Usuario::class);
    }

    public function hasApuracoesPendentes(){
        return $this->apuracoes()->whereIn('apuracao.status',['Pendente', 'Novo'])->count() > 0 ? true : false;
    }

    public function qtdApuracoesPendentes(){
        return $this->apuracoes()->whereIn('apuracao.status',['Pendente', 'Novo'])->count();
    }

    public function hasDocumentosContabeisPendentes(){
        return $this->documentosContabeis()->whereIn('processo_documento_contabil.status',['pendente', 'novo'])->count() > 0 ? true : false;
    }

    public function qtdDocumentosContabeisPendentes(){
        return $this->documentosContabeis()->whereIn('processo_documento_contabil.status',['pendente', 'novo'])->count();
    }

    public function hasPagamentosPendentes(){
        return $this->ordensPagamento()->whereNotIn('ordem_pagamento.status',['Paga', 'Disponível'])->count() > 0 ? true : false;
    }

    public function qtdPagamentosPendentes(){
        return $this->ordensPagamento()->whereNotIn('ordem_pagamento.status',['Paga', 'Disponível'])->count();
    }

}
