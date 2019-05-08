<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AeronaveValores extends Model
{
    protected $table= 'aeronaves_valores';
    protected $fillable= ['minutos','preco'];

    public $timestamps=false;


    public function aeronaves(){
        return $this->belongsToMany('App\Aeronave' );
    }
}
