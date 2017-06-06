<?php

namespace App\Policies;

use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class empresaPolicy
 * @package App\Policies
 */
class EmpresaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user is admin
     * @param Usuario $user
     * @return mixed
     */
    public function before(Usuario $user)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the empresa.
     *
     * @param Usuario $user
     * @param empresa $empresa
     * @return mixed
     */
    public function view(Usuario $user, Empresa $empresa)
    {
        if($empresa->id_usuario == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create empresas.
     *
     * @param Usuario $user
     * @return mixed
     */
    public function create(Usuario $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the empresa.
     *
     * @param Usuario $user
     * @param empresa $empresa
     * @return mixed
     */
    public function update(Usuario $user, Empresa $empresa)
    {
        if($empresa->id_usuario == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the empresa.
     *
     * @param Usuario $user
     * @param empresa $empresa
     * @return mixed
     */
    public function delete(Usuario $user, Empresa $empresa)
    {
        if($empresa->id_usuario == $user->id){
            return true;
        }
        return false;
    }

    public function sendMessage(Usuario $user, Empresa $empresa)
    {
        if($empresa->id_usuario == $user->id){
            return true;
        }
        return false;
    }
}
