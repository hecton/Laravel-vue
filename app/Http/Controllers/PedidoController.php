<?php

namespace App\Http\Controllers;

use App\Exports\PedidoExport;
use App\Http\Requests\PedidoCreateRequest;
use App\Http\Requests\PedidoUpdateRequest;
use App\Repositories\Contracts\PedidoInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class PedidoController extends Controller
{
    public function __construct(
        protected PedidoInterface $pedidoInterface
    ) { }


    /**
     * return page with all orders
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Orders/All');
    }

    /**
     * return order form page
     *
     * @param string|int $order_id
     * @return Response
     */
    public function form(string $order_id = null): Response
    {
        return Inertia::render('Orders/Form', [ 'order_id' => $order_id ]);
    }


    /**
    * create a order
    *
    * @param  PedidoCreateRequest $request
    * @return JsonResponse
    */
    public function create(PedidoCreateRequest $request): JsonResponse
    {
        $pedido = $this->pedidoInterface->create($request->all());
        return response()->json([
            'msg' => 'Pedido criado  com sucesso',
            'pedido' => $pedido
        ], 200);
    }


    /**
        * update order
        *
        * @param  PedidoUpdateRequest $request
        * @return JsonResponse
        */
    public function update(PedidoUpdateRequest $request): JsonResponse
    {
        $pedido = $this->pedidoInterface->update($request->all());
        return response()->json([
            'msg' => 'Pedido atualizado com sucesso',
            'pedido' => $pedido
        ], 200);
    }


    /**
        * get all orders or filter
        *
        * @param  Request $request
        * @return JsonResponse
        */
    public function getAll(Request $request): JsonResponse
    {
        return response()->json( $this->pedidoInterface->getAll($request->filter), 200 );
    }

    /**
        * get all status avaliables
        *
        * @return JsonResponse
        */
    public function getPedidoStatus(): JsonResponse
    {
        return response()->json( $this->pedidoInterface->getPedidoStatus(), 200 );
    }

    /**
    * find by id
    *
    * @param  string|int $id
    * @return JsonResponse
    */
    public function findOne(string|int $id): JsonResponse
    {
        return response()->json( $this->pedidoInterface->findOne($id), 200 );
    }

    /**
    * delete a pedido
    *
    * @param  mixed $id
    * @return JsonResponse
    */
    public function delete(string|int $id): JsonResponse
    {
        $this->pedidoInterface->delete($id);

        return response()->json([
            'msg' => 'Pedido removido com sucesso',
        ], 200);
    }

    /**
     * export
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        return Excel::download(new PedidoExport, 'pedidos.xlsx');
    }
}
