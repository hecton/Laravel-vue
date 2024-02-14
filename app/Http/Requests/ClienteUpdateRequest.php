<?php

namespace App\Http\Requests;

use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;

class ClienteUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:clientes,id',
            'nome' => ["required", "string", "regex: /^[aA-zZáàâãéèêíïóôõöúçñ]{2,}(\s[aA-zZáàâãéèêíïóôõöúçñ]{1,})+$/"],
            'cpf' => ["required", new CPF],
            'data_nasc' => 'required|date|before:today',
            'telefone' => ["nullable", "regex:/^\(?[1-9]{2}\)?\s?\d{4,5}(\-|\s)?\d{4}$/"],
            'ativo' => 'required|boolean',
        ];
    }

    /**
     * attribute's title
     *
     * @return array<string>
     */
    public function attributes(): array
    {
        return [
            'cpf' => 'CPF',
            'data_nasc' => 'data de nascimento',
        ];
    }


    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'data_nasc.before' => 'data de nascimento não pode ser maior que a data atual',
        ];
    }
}
