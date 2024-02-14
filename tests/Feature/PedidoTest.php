<?php

namespace Tests\Feature;

use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    /** @test */
    public function check_if_create_function_is_working(): void
    {
        $pedido_data = Pedido::factory()->make()->toArray();

        $response = $this->post('/pedidos/create', $pedido_data, ['Accept' => 'application/json',  "Content-Type" =>  'multipart/form-data']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'msg' => 'Pedido criado  com sucesso',
                'pedido' => $pedido_data
            ]);

        $content = json_decode($response->getContent());
        $pedido = Pedido::find($content->pedido->id);
        $this->assertTrue(!empty(  $pedido ));

        if(!empty($pedido)){
            $pedido->delete();
        }
    }


    /** @test */
    public function check_if_update_function_is_working(): void
    {
        $pedido = Pedido::factory()->create();
        $pedido_data = $pedido->toArray();
        $pedido_data['produto'] = 'nome teste';

        $response = $this->post('/pedidos/update', $pedido_data, ['Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'msg' => 'Pedido atualizado com sucesso',
                'pedido' => $pedido_data
            ]);

        $pedido->refresh();
        $this->assertTrue($pedido->produto == $pedido_data['produto']);
        $pedido->delete();
    }

    /** @test */
    public function check_if_update_can_add_images(): void
    {
        $pedido = Pedido::factory()->create();
        $pedido_data = $pedido->toArray();
        $pedido_data['uploaded_images'] = [
            UploadedFile::fake()->image('test.jpg')
        ];

        $response = $this->post('/pedidos/update', $pedido_data, ['Accept' => 'application/json']);

        $pedido_data['imagens'] = true;
        $response
            ->assertStatus(200)
            ->assertJson([
                'msg' => 'Pedido atualizado com sucesso',
                'pedido' => true
            ]);

        $pedido->refresh();
        $this->assertTrue(
            $pedido->imagem->count() > 0
        );
        $pedido->delete();
    }

    /** @test */
    public function check_if_get_all_function_is_working(): void
    {
        $new_pedidos = Pedido::factory(10)->create();
        $pedidos = Pedido::all();



        $response = $this->get('/pedidos/getAll');

        $response
            ->assertStatus(200)
            ->assertJson($pedidos->toArray());

        $new_pedidos->each(function ($pedido) {
            $pedido->delete();
        });

    }

    /** @test */
    public function check_if_find_one_function_is_working(): void
    {

        $pedido = Pedido::factory()->create();

        $response = $this->get("/pedidos/findOne/$pedido->id");

        $response
            ->assertStatus(200)
            ->assertJson($pedido->toArray());


        $pedido->delete();
    }
}
