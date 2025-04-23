<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductSaveRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;


class ProductController extends Controller {

    public function __construct(Product $product) {

        $this->product = $product;
    }

    /********************************************************************************************************/
    
    public function index(Request $request) {

        $productRepository = new ProductRepository($this->product);

        if($request->has('atributos')) {

            $productRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $productRepository->selectWith($request->with);
        }

        if($request->has('filter')) {

            $productRepository->filter($request->filter);
        }

        if($request->has('extendedFilter')) {

            $productRepository->extendedFilter($request->extendedFilter);
        }

        if($request->has('sort')) {

            $productRepository->sort($request->sort);
        }

        if($products = $productRepository->getResultado()) {   

            return new ProductResource($products);            
        }
        
        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /********************************************************************************************************/

    public function store(ProductSaveRequest $request) {

        if($store = $this->product->create($request->all())) {
            
            return response()->json([ 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }

    /********************************************************************************************************/

    public function update(ProductSaveRequest $request, $product) {

        if($update = $this->product->find($product)) {

            if($update->update($request->all())) {

                return response()->json([ 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);

    }

    /********************************************************************************************************/

    public function show($product) {        
        
        $product = $this->product
        ->with('category', 'files')
        ->findOrFail($product);

        $product->stock = $product->getCurrentStock();

        return new ProductResource($product);
    }

    /********************************************************************************************************/

    public function destroy($product) {

        if($destroy = $this->product->find($product)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}
