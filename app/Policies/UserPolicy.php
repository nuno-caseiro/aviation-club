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

/*
    public function create(User $auth){
        if ($auth->isDirecao()){
            return true;
        }
        return false;
    }

*/


    public function update_DirMe(User $auth, User $socio){
        return ($auth->isDirecao() || $socio->id == $auth->id) && $auth->isAtivo() ;
    }



    public function socio_Direcao(User $auth)
    {
        return $auth->isDirecao() && $auth->hasVerifiedEmail() && $auth->isAtivo();
    }

    public function socio_DP(User $auth)
    {
        return $auth->isDirecao()|| $auth->isPiloto();
    }


    public function socio_Piloto(User $auth){
        return !$auth->isDirecao() && $auth->isPiloto();
    }

    public function listar(User $auth){
        return  $auth->isAtivo() && $auth->NotSoftDeleted() ;
    }



    public function socio_normal(User $auth)
    {
        return !$auth->isDirecao();
    }


    public function destroyAeronave(User $auth){
        if ($auth->isDirecao()){
            return true;
        }
        return false;
    }

    public function delete_socio(User $auth){
        return $auth->isDirecao();

    }

}
