<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'email'             => 'cast:string',
            'senha'             => 'cast:string',
            'repetirSenha'      => 'cast:string'
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
            'nome'          => 'required',
            'email'         => 'required',
            'senha'         => 'required',
            'repetirSenha'  => 'required'
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
            'nome.required'             => __('requests/usuario/register.nome'),
            'email.required'            => __('requests/usuario/register.email_required'),
            'email.email'               => __('requests/usuario/register.email_email'),
            'senha.required'            => __('requests/usuario/register.senha'),
            'repetirSenha.required'     => __('requests/usuario/register.repetirSenha'),
        ];
    }
}
