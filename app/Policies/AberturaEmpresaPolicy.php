<?php

namespace App\Policies;

use App\Models\AberturaEmpresa;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class AberturaEmpresaPolicy
 * @package App\Policies
 */
class AberturaEmpresaPolicy
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
     * Determine whether the user can view the aberturaEmpresa.
     *
     * @param Usuario $user
     * @param AberturaEmpresa $aberturaEmpresa
     * @return mixed
     */
    public function view(Usuario $user, AberturaEmpresa $aberturaEmpresa)
    {
        if($aberturaEmpresa->id_usuario == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create aberturaEmpresas.
     *
     * @param Usuario $user
     * @return mixed
     */
    public function create(Usuario $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the aberturaEmpresa.
     *
     * @param Usuario $user
     * @param AberturaEmpresa $aberturaEmpresa
     * @return mixed
     */
    public function update(Usuario $user, AberturaEmpresa $aberturaEmpresa)
    {
        if($aberturaEmpresa->id_usuario == $user->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the aberturaEmpresa.
     *
     * @param Usuario $user
     * @param AberturaEmpresa $aberturaEmpresa
     * @return mixed
     */
    public function delete(Usuario $user, AberturaEmpresa $aberturaEmpresa)
    {
        if($aberturaEmpresa->id_usuario == $user->id){
            return true;
        }
        return false;
    }
}
