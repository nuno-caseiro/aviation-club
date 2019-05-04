<?php
namespace App\Providers;
use App\Aeronave; // write model name here 
use Illuminate\Support\ServiceProvider;
class DynamicAeronaves extends ServiceProvider
{
    public function boot()
    {
        view()->composer('*',function($view){
            $view->with('aeronaves', Aeronave::all());
        });
    }

}

