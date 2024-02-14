<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'cpf' => fake()->cpf(),
            'data_nasc' => fake()->datetime(now()->subYears(18))->format('Y-m-d H:i:s'),
            'telefone' => null,
            'ativo' => 1,
        ];
    }
}
