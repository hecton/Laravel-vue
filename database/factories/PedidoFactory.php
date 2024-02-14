<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;
use App\Models\PedidoStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $status = PedidoStatus::first();
        $cliente = Cliente::factory()->create();

        return [
            'produto' => fake()->name,
            'valor' => fake()->randomFloat(2, 100, 1000000),
            'data' => fake()->datetime()->format('Y-m-d H:i:s'),
            'cliente_id' => $cliente->id,
            'pedido_status_id' => $status->id,
            'ativo' => fake()->boolean,
        ];
    }
}
