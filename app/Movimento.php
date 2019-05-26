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
   // protected $fillable = ['id', 'aeronave', 'data_inf', ' data_sup', 'natureza', 'confirmado','piloto','instrutor','meus_movimentos'];
   
   

  protected $fillable = ['data',
'hora_descolagem', 'hora_aterragem', 'aeronave','num_diario',
'num_servico', 'piloto_id', 'natureza', 'aerodromo_partida',
'aerodromo_chegada','num_aterragens','num_descolagens',
'num_pessoas','conta_horas_inicio','conta_horas_fim','tempo_voo',
'preco_voo', 'modo_pagamento', 'num_recibo','observacoes',
'tipo_instrucao', 'instrutor_id','num_licenca_piloto','validade_licenca_piloto','tipo_licenca_piloto','num_certificado_piloto','validade_certificado_piloto','classe_certificado_piloto','confirmado','instrutor_id','validade_licenca_instrutor','validade_certificado_instrutor','classe_certificado_instrutor','tipo_licenca_instrutor','num_licenca_instrutor','num_certificado_instrutor'];
   


 public function movimentosUser(){
        return $this->belongsToMany('App\User','id');
    }

}
