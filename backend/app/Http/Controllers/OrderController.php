<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\OrderSaveRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller {

    public function __construct(Order $order) {

        $this->order = $order;
    }

    /********************************************************************************************************/

    public function index(Request $request) {

        $orderRepository = new OrderRepository($this->order);

        if($request->has('atributos')) {

            $orderRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $orderRepository->selectWith($request->with);
        }

        if($request->has('filter')) {

            $orderRepository->filter($request->filter);
        }

        if($orders = $orderRepository->getResultado()) {   

            return new OrderResource($orders);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /********************************************************************************************************/

    public function store(OrderSaveRequest $request) {

        if($store = $this->order->create($request->all())) {

            return response()->json([ 'errors' => [], 'msg' => 'Ordem de venda criada com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404); 
    }

    /********************************************************************************************************/

    public function update(OrderSaveRequest $request, $order) {

        if($update = $this->order->find($order)) {

            if($update->update($request->all())) {

                return response()->json([ 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /********************************************************************************************************/

    public function show($order) {        
        
        return new OrderResource($this->order->findOrFail($order));
    }

    /********************************************************************************************************/
    
    public function destroy($order) {

        if($destroy = $this->order->find($order)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}
