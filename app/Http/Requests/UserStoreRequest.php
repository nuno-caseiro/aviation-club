<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nome_informal' => 'required|max:40',
            'nif' => 'max:9',
            'telefone'=> 'max:20',
            'num_socio' => 'required|max:11',
            'file_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'data_nascimento' => 'required|date_format:Y-m-d|before:today',
            'email' => [
                'email',
                Rule::unique('users')->ignore($this->id),
            ],
            'tipo_socio' => 'required| between:P,NP,A',
            'quota_paga' => 'required|between:0,1',
            'ativo' => 'required|between:0,1',
            'sexo' => 'required|between:M,F',
            'direcao' => 'required|between:0,1',
            'certificado-confirmado' => 'between:0,1',
            'aluno' => 'between:0,1',
            'instrutor' => 'required|between:0,1',
            'classe_certificado'=>'exists:classes_certificados,code',




        ];
    }
}
