<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Aeronave extends Model
{
    public $matricula;
    public $marca;
    public $modelo;
    public $num_lugares;
    public $conta_horas;
    public $preco_hora;
    public $tempos;
    public $precos;





    protected $table= 'aeronavesController';

    /**
     * Aeronave constructor.
     * @param $matricula
     * @param $marca
     * @param $modelo
     * @param $num_lugares
     * @param $conta_horas
     * @param $preco_hora
     * @param $tempos
     * @param $precos
     * @param $deleted_at
     */
    public function __construct($matricula, $marca, $modelo, $num_lugares, $conta_horas, $preco_hora, $tempos, $precos)
    {
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->num_lugares = $num_lugares;
        $this->conta_horas = $conta_horas;
        $this->preco_hora = $preco_hora;
        $this->tempos = $tempos;
        $this->precos = $precos;

    }


}
