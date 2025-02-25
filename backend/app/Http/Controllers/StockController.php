<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Repositories\StockRepository;
use App\Http\Requests\StockSaveRequest;
use App\Http\Resources\StockResource;
use Illuminate\Http\Request;

class StockController extends Controller {

    public function __construct(Stock $stock) {

        $this->stock = $stock;
    }

    /************************************************************************************/
    public function index(Request $request) {

        $stockRepository = new StockRepository($this->stock);

        if($request->has('atributos')) {

            $stockRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $stockRepository->selectWith($request->with);
        }

        if($request->has('filter')) {

            $stockRepository->filter($request->filter);
        }

        if($request->has('subFilter')) {

            $stockRepository->subFilter('product,'.$request->subFilter);
        }

        if($stock = $stockRepository->getResultado()) {   

            return new StockResource($stock);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /************************************************************************************/
    public function store(StockSaveRequest $request) {

        if($store = $this->stock->create($request->all())) {
            
            return response()->json([ 'stock' => $store, 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }

    /************************************************************************************/
    public function show(string $stock)  {

        return new StockResource($this->stock->with('product')->findOrFail($stock));
    }

    /************************************************************************************/
    public function update(StockSaveRequest $request, string $stock) {

        if($update = $this->stock->find($stock)) {

            if($update->update($request->all())) {

                return response()->json([ 'stock' => $update, 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);
    }

    /************************************************************************************/
    public function destroy(string $stock) {
        
        if($destroy = $this->stock->find($stock)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}
