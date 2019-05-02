<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utilizador extends Model
{
    protected $table= 'usersController';
    protected $primaryKey = 'id';


   // protected $fillable = ['nome_informal','name','email','foto_url','data_nascimento','nif','telefone','endereco'];
    public $incrementing = false;
}
