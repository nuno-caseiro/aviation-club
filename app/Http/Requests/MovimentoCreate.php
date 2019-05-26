<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimentoCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data'=>'required|date_format:Y-m-d',
            'hora_descolagem'=>'required|date_format:H:i',
            'hora_aterragem'=>'required|date_format:H:i',
            'aeronave' => 'required|exists:aeronaves,matricula',
            'num_diario'=>'required|integer',
            'num_servico'=>'required|integer',
            'piloto_id'=>'required|exists:users,id,tipo_socio,P',
            'natureza'=>'required|in:T,I,E',
            'aerodromo_partida'=>'required|exists:aerodromos,code',
            'aerodromo_chegada'=>'required|exists:aerodromos,code',
            'num_aterragens'=>'required|integer|min:0',
            'num_descolagens'=>'required|integer|min:0',
            "conta_horas_inicio"=> 'required|integer|min:0',
            "conta_horas_fim"=> 'required|integer|min:0|gt:conta_horas_inicio',
            "tempo_voo"=>'required|integer|min:0',
            "preco_voo"=>'required|numeric|min:0',
            "modo_pagamento"=>'required|in:N,M,T,P',
            "num_recibo"=>'required|digits_between:1,20',
            "tipo_instrucao"=>'nullable|required_if:natureza,==,I|in:D,S',
            "instrutor_id"=>'nullable|required_if:natureza,I|exists:users,id,tipo_socio,P,instrutor,1',
            "num_pessoas"=>'required|integer|min:1'


        ];
    }
}
