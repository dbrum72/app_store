<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Requests\OrderItemSaveRequest;
use App\Http\Resources\OrderItemResource;
use App\Repositories\OrderItemRepository;
use Illuminate\Http\Request;

class OrderItemController extends Controller {

    public function __construct(OrderItem $pedido_product) {

        $this->pedido_product = $pedido_product;
    }

    /********************************************************************************************************/

    public function index(Request $request) {
        
        $pedido_productRepository = new OrderItemRepository($this->pedido_product);

        if($request->has('atributos')) {

            $pedido_productRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $pedido_productRepository->selectWith($request->with);
        }

        if($request->has('filter')) {

            $pedido_productRepository->filter($request->filter);
        }

        if($pedidos = $pedido_productRepository->getResultado()) {   

            return new OrderItemResource($pedidos);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /********************************************************************************************************/

    public function store(OrderItemSaveRequest $request) {

        if($store = $this->pedido_product->create($request->all())) {

            return response()->json([ 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404); 
    }

    /********************************************************************************************************/

    public function update(OrderItemSaveRequest $request, $pedido_product) {
        
        if($update = $this->pedido_product->find($pedido_product)) {

            if($update->update($request->all())) {

                return response()->json([ 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }
        
        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /********************************************************************************************************/
    
    public function destroy($pedido_product) {

        if($destroy = $this->pedido_product->find($pedido_product)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}
