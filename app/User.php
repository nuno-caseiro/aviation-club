<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
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

    public function classeCertificados(){
        return $this->belongsToMany('App\ClassesCertificados' );
    }
    public function tiposLicencas(){
        return $this->belongsToMany('App\TiposLicencas' );
    }

    public function typeToStr()
    {
        switch ($this->tipo_socio) {
            case 'P':
                return 'Piloto';
            case 'NP':
                return 'Normal';
            case 'A':
                return 'Aeromodelista';
        }
        return 'Unknown';
    }
    public function isPiloto()
    {
        return $this->tipo_socio === 'P';
    }
    public function isNormal()
    {
        return $this->tipo_socio === 'NP';
    }
    public function isAeromodelista()
    {
        return $this->tipo_socio === 'A';
    }
    public function isAtivo()
    {
        return $this->ativo === 1;
    }
    public function isInstrutor()
    {
        return $this->instrutor===1;
    }
    public function isAluno()
    {
        return $this->aluno===1;
    }
    public function isDirecao()
    {
        return $this->direcao===1;
    }

}
