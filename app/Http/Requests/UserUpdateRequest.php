<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserUpdateRequest extends FormRequest
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
            'name' => 'required|alpha_spaces', //teste
            'nome_informal' => 'required|max:40',
            'nif' => 'max:9',
            'telefone'=> 'max:20',
            'num_socio' => ['required','integer','min:1',
                Rule::unique('users','num_socio')->ignore($this->id)],

            'file_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'data_nascimento' => 'required|date_format:Y-m-d|before:today',
            'email' => [
                'email',
                Rule::unique('users','email')->ignore($this->id),
            ],
            'num_licenca'=>'nullable|max:30',
            'tipo_licenca'=>'nullable|exists:tipos_licencas,code',
            'num_certificado'=> 'nullable|max:30',
            'classe_certificado'=>'nullable|exists:classes_certificados,code',
            'validade_licenca' => 'nullable|date|date_format:Y-m-d|after_or_equal:today',
            'validade_certificado' => 'nullable|date|date_format:Y-m-d|after_or_equal:today',
            'aluno' => 'between:0,1',
            'instrutor' => 'required|between:0,1',
            'direcao' => 'required|between:0,1',
            'ativo' => 'required|between:0,1',
            'quota_paga' => 'required|between:0,1',
            'tipo_socio' => 'required| between:P,NP,A',
            'sexo' => 'required|between:M,F',




        ];
    }
}
