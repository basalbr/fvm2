<?php

namespace App\Models;

use App\Overrides\Auth\Passwords\CanResetPassword;
use App\Overrides\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @property boolean admin
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

    public function errors()
    {
        return $this->errors;
    }

    public function getAuthPassword()
    {
        return $this->attributes['senha']; //change the 'passwordFieldinYourTable' with the name of your field in the table
    }

    public function chamados()
    {
        return $this->hasMany(Chamado::class, 'id_usuario');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'id_usuario');
    }

    public function aberturasEmpresa()
    {
        return $this->hasMany(AberturaEmpresa::class, 'id_usuario');
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
        $this->attributes['nome'] = ucwords($nome);
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

}
