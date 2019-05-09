<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiposLicencas extends Model
{
    protected $table= 'tipos_licencas';

    public function tiposLicencas(){
        return $this->hasMany('App\User', 'tipo_licenca');
    }
}
