<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function create(User $auth){
        if ($auth->isDirecao()){
            return true;
        }
        return false;
    }



    public function update(User $auth, User $socio){
        return $auth->isDirecao() || $socio->id === $auth->id;
    }

    public function list(User $auth)
    {
        return $auth->isDirecao();
    }


    public function normal_list_ativo(User $auth)
    {
        return $auth->isNormal() || $auth->isAeromodelista() || $auth->isPiloto();
    }

}
