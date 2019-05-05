<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PilotosAutorizados extends Model
{

    protected $table='aeronaves_pilotos';

    public function pilotosAutorizados(){
        return $this->belongsToMany('App\Aeronave' );
    }

}
