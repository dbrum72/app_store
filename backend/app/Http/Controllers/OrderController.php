<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockMovement;
use App\Http\Requests\OrderSaveRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return DB::transaction(function () use ($request) {

            $order = Order::create();

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $stock = $product->getCurrentStock();

                if ($stock < $item['quantity']) {
                    throw new \Exception("Estoque insuficiente para o produto: {$product->name}");
                }

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);

                StockMovement::create([
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'reason'     => 'out',
                    'type'       => 'sale',
                ]);
            }

            return response()->json([$order->load('items.product'), 'errors' => [], 'msg' => 'Ordem de venda criada com sucesso!'], 201);
        }, 3); // 3 tentativas em caso de deadlock
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
