<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteCreateRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Repositories\Contracts\ClienteInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClienteController extends Controller
{
    public function __construct(
        protected ClienteInterface $clienteInterface
    ){}


    /**
     * return page with all clientes
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Clients/All');
    }

    /**
     * return client form page
     *
     * @param string|int $client_id
     * @return Response
     */
    public function form(string $client_id = null): Response
    {
        return Inertia::render('Clients/Form', [ 'client_id' => $client_id ]);
    }


    /**
     * createa client
     *
     * @param  ClienteCreateRequest $request
     * @return JsonResponse
     */
    public function create(ClienteCreateRequest $request): JsonResponse
    {
        $client = $this->clienteInterface->create($request->all());
        return response()->json([
            'msg' => 'Cliente criado  com sucesso',
            'cliente' => $client
        ], 200);
    }


    /**
     * update client
     *
     * @param  ClienteUpdateRequest $request
     * @return JsonResponse
     */
    public function update(ClienteUpdateRequest $request): JsonResponse
    {
        $client = $this->clienteInterface->update($request->all());
        return response()->json([
            'msg' => 'Cliente atualizado com sucesso',
            'cliente' => $client
        ], 200);
    }


    /**
     * get all clientes or filter
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function getAll(Request $request): JsonResponse
    {
        return response()->json( $this->clienteInterface->getAll($request->filter), 200 );
    }

    /**
     * find by id
     *
     * @param  string|int $id
     * @return JsonResponse
     */
    public function findOne(string|int $id): JsonResponse
    {
        return response()->json( $this->clienteInterface->findOne($id), 200 );
    }

    /**
     * delete a cliente
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function delete(string|int $id): JsonResponse
    {
        $this->clienteInterface->delete($id);

        return response()->json([
            'msg' => 'Cliente removido com sucesso',
        ], 200);
    }
}
