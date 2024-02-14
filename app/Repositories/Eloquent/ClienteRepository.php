<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\ClienteInterface;
use App\Models\Cliente;
use stdClass;

class ClienteRepository implements ClienteInterface
{
    public function __construct(protected Cliente $cliente)
    {}


    /**
     * createa client
     *
     * @param  array<mixed> $data
     * @return stdClass
     */
    public function create(array $data): stdClass
    {
        return (object) $this->cliente->create($data)->toArray();
    }


    /**
     * update client
     *
     * @param  array<mixed> $data
     * @return stdClass
     */
    public function update(array $data): stdClass
    {
        $client = $this->cliente->find($data['id']);

        if(empty($client)){
            abort( response()->json([ 'msg' => 'cliente não  encontrado' ], 200 ) );
        }

        $client->update($data);

        return (object) $client->toArray();
    }


    /**
     * get all clientes or filter
     *
     * @param  mixed $filter - (optional) filter by name
     * @return array
     */
    public function getAll(string $filter = null): array
    {
        return $this->cliente
            ->where(function ($query) use ($filter){
                if($filter){
                    $query->where('nome', 'like', "%$filter%");
                }
            })
            ->get()
            ->toArray();
    }

    /**
     * find by id
     *
     * @param  string|int $id
     * @return stdClass
     */
    public function findOne(string|int $id): stdClass
    {
        $client = $this->cliente->find($id);

        if(empty($client)){
            abort( response()->json([ 'msg' => 'cliente não  encontrado' ], 200 ) );
        }

        return (object) $client->toArray();
    }

    /**
     * delete a cliente
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(string|int $id): void
    {
        $client = $this->cliente->find($id);

        if(empty($client)){
            abort( response()->json([ 'msg' => 'cliente não  encontrado' ], 200 ) );
        }

        $client->pedidos()->each(function($pedido) {
            $pedido->delete();
        });

        $client->delete();
    }
}
