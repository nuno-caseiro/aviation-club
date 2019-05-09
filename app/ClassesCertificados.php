<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassesCertificados extends Model
{
    protected $table= 'classes_certificados';


    public function classeCertificados(){
        return $this->hasMany('App\User', 'classe_certificado');
    }
}
