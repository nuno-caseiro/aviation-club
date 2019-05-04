<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Movimento extends Model
{
    //
     protected $table= 'movimentos';
      protected $primaryKey = 'id';
    //pouuurra estava complicado
    public $incrementing = true;
    protected $fillable = ['id', 'aeronave', 'data_inf', ' data_sup', 'natureza', 'confirmado','piloto','instrutor','meus_movimentos'];
   
}
