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
            'num_socio' => 'required|max:11',
            'file_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'data_nascimento' => 'required',
           /* 'tipo_socio'=> 'required',
            'quota_paga'=> 'required',
            'ativo'=> 'required',
            'direcao' =>'required',*/

           // 'email'=>'email|unique:users,email,'.$this->user()->id, //check //apenas o user atual
            'email' => [
                'email', 'required',
                Rule::unique('users')->ignore($this->user()->id),
            ],

        ];
    }
}
