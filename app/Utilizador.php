<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utilizador extends Model
{
    protected $table= 'usersController';
    protected $primaryKey = 'id';


   // protected $fillable = ['num_socio','nome_informal','email','tipo','direcao','quotas_pagas','ativo'];
    public $incrementing = false;
}
