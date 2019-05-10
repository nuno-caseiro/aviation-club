<?php



namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //


        Gate::define('normal_list_ativo', function($user){
            return $user->isNormal() || $user->isAeromodelista();
        });


        Gate::define('list', function($user){
            return $user->isDirecao();
        });

        Gate::define('update', function(User $user, User $auth){
            return $user->isDirecao() || $user->id === $auth->id;
        });



    }
}
