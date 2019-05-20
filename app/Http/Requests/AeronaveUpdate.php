<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AeronaveUpdate extends FormRequest
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
            'matricula'=> 'required|alpha_dash|max:8',
            'marca'=>'required|max:40',
            'modelo' => 'required|max:40',
            'num_lugares' => 'required|integer|min:1',
            'conta_horas'=>'required|integer|min:1',
            'preco_hora' => 'required|numeric|min:1',
            'tempos.*'=> 'required|numeric|integer|min:0',
            'precos.*'=> 'required|numeric|min:0',
        ];
    }
}
