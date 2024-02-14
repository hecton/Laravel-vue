<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoCreateRequest extends FormRequest
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
            'produto' => 'required|string|min:1|max:255',
            'valor' => 'required|numeric',
            'data' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'pedido_status_id' => 'required|exists:pedido_status,id',
            'ativo' => 'required|boolean',
            'imagem' => 'nullable|array',
            'imagem.*' => 'required|exists:pedidos_imagens,id',
            'uploaded_images' => 'nullable|array',
            'uploaded_images.*' => 'nullable|mimes:jpeg,png,jpg'
        ];
    }

    /**
     * attributes titles
     *
     * @return array<string>
     */
    public function attributes(): array
    {
        return [
            'client_id' => 'cliente',
            'pedido_status_id' => 'status do pedido',
            'imagem.*' => 'imagem',
            'uploaded_images' => 'imagem',
            'uploaded_images.*' => 'imagem',
        ];
    }
}
