<?php
namespace App\Providers;
use App\Movimento; // write model name here 
use Illuminate\Support\ServiceProvider;
class DynamicMovimentos extends ServiceProvider
{
    public function boot()
    {
        view()->composer('*',function($view){
            $view->with('movements', Movimento::all());//nao pode ser movimentos cria problemas de colisao de nomes  com a lista 
        });
    }

}

