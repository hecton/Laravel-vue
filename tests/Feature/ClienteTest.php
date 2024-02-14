<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cliente;

class ClienteTest extends TestCase
{

    /** @test */
    public function check_if_create_function_is_working(): void
    {
        $client_data = Cliente::factory()->make()->toArray();

        $response = $this->post('/clientes/create', $client_data, ['Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'msg' => 'Cliente criado  com sucesso',
                'cliente' => $client_data
            ]);

        $content = json_decode($response->getContent());
        $cliente = Cliente::find($content->cliente->id);
        $this->assertTrue(!empty(  $cliente ));

        if(!empty($cliente)){
            $cliente->delete();
        }
    }


    /** @test */
    public function check_if_update_function_is_working(): void
    {
        $client = Cliente::factory()->create();
        $client_data = $client->toArray();
        $client_data['nome'] = 'nome teste';

        $response = $this->put('/clientes/update', $client_data, ['Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'msg' => 'Cliente atualizado com sucesso',
                'cliente' => $client_data
            ]);

        $client->refresh();
        $this->assertTrue($client->nome == $client_data['nome']);

        $client->delete();
    }

    /** @test */
    public function check_if_get_all_function_is_working(): void
    {
        $new_clientes = Cliente::factory(10)->create();
        $clients = Cliente::all();

        $response = $this->get('/clientes/getAll');

        $response
            ->assertStatus(200)
            ->assertJson($clients->toArray());

        $new_clientes->each(function ($client) {
            $client->delete();
        });

    }

    /** @test */
    public function check_if_find_one_function_is_working(): void
    {

        $client = Cliente::factory()->create();

        $response = $this->get("/clientes/findOne/$client->id");

        $response
            ->assertStatus(200)
            ->assertJson($client->toArray());


        $client->delete();
    }
}
