<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Aeronave extends Model
{
    protected $table= 'aeronavesController';
    protected $primaryKey = 'matricula';
    //pouuurra estava complicado

    protected $fillable = ['matricula', 'marca', 'modelo', 'num_lugares', 'conta_horas', 'preco_hora'];
    public $incrementing = false;







}
