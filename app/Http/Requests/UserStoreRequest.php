<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
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
        $rules= [
            'name' => 'required|alpha_spaces', //teste
            'nome_informal' => 'required|max:40',
            'nif' => 'max:9',
            'telefone'=> 'max:20',
            'num_socio' => ['required','integer','min:1',Rule::unique('users')->ignore($this->id)],

            'file_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'data_nascimento' => 'required|date_format:Y-m-d|before:today',
            'email' => [
                'required','email',Rule::unique('users')->ignore($this->id)],

            'num_licenca'=>'nullable|max:30',
            'tipo_licenca'=>'nullable|exists:tipos_licencas,code',
            'num_certificado'=> 'nullable|max:30',
            'classe_certificado'=>'nullable|exists:classes_certificados,code',
            'validade_licenca' => 'nullable|date|date_format:Y-m-d|after_or_equal:today',
            'validade_certificado' => 'nullable|date|date_format:Y-m-d|after_or_equal:today',
            'direcao' => 'required|in:0,1',
            'ativo' => 'required|in:0,1',
            'quota_paga' => 'required|in:0,1',
            'tipo_socio' => 'required| in:P,NP,A',
            'sexo' => 'required|in:M,F',
            'certificado_confirmado'=>'nullable|in:0,1',
            'licenca_confirmada'=>'nullable|in:0,1',


        ];

        //Input::get('aluno')!=0 && Input::get('instrutor')!=0  &&
        if (Input::get('instrutor')==0 && Input::get('aluno')==0) {
            $rules+=['aluno' => 'in:0|nullable',
                'instrutor'=>'in:0|nullable'];
        }else{
            $rules+=['aluno' => 'in:0,1|different:instrutor',
                'instrutor'=>'in:0,1|different:aluno'];

        }

        return $rules;
    }
}
