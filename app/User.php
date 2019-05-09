<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table= 'users';
    protected $primaryKey = 'id'; // preciso disto?
  //  protected $fillable = [
      //  'name', 'email', 'password','num_socio','nome_informal','tipo','direcao','quotas_pagas','ativo'
   // ]; //nome,email,password , ja vem por defeito da autenticacao
    protected $fillable=['name','email','password','num_socio','nome_informal','sexo','data_nascimento','nif','telefone','endereco','tipo_socio','quota_paga','ativo','direcao','num_licenca','tipo_licenca','instrutor','aluno','validade_licenca','licenca_confirmada','num_certificado','classe_certificado','validade_certificado','certificado_confirmado'];//???



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    //protected $fillable = ['num_socio','nome_informal','email','tipo','direcao','quotas_pagas','ativo']; -- ir la p cima??
   // public $incrementing = false;

    public function pilotosAeronaves(){
        return $this->hasMany('App\AeronavePilotos', 'id');
    }

}
