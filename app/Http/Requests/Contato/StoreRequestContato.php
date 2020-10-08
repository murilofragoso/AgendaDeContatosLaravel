<?php

namespace App\Http\Requests\Contato;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestContato extends FormRequest
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
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return [
            'nome'              => 'cast:string',
            'idUsuario'         => 'cast:integer',
            'telefones'         => [
                'numero'        => 'cast:string'
            ],
            'enderecos'         => [
                'cep'           => 'cast:string',
                'logradouro'    => 'cast:string',
                'numero'        => 'cast:integer',
                'bairro'        => 'cast:string',
                'complemento'   => 'cast:string',
                'cidade'        => 'cast:string',
                'uf'            => 'cast:string',
            ]
        ];
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome'         => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required'            => __('requests/contato/store.nome_required')
        ];
    }
}
