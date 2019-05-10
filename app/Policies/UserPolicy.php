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


    public function create(User $user){
        if ($user->isDirecao()){
            return true;
        }
    }


    public function update(User $user, User $model, $auth){
        return $user->isDirecao() || $user->id == $auth->id;
    }
}
