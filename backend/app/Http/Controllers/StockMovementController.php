<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Repositories\StockMovementRepository;
use App\Http\Requests\StockMovementSaveRequest;
use App\Http\Resources\StockMovementResource;
use Illuminate\Http\Request;

class StockMovementMovementController extends Controller {

    public function __construct(StockMovement $stockMovement) {

        $this->stockMovement = $stockMovement;
    }

    /************************************************************************************/
    public function index(Request $request) {

        $stockMovementRepository = new StockMovementRepository($this->stockMovement);

        if($request->has('atributos')) {

            $stockMovementRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $stockMovementRepository->selectWith($request->with);
        }

        if($request->has('filter')) {

            $stockMovementRepository->filter($request->filter);
        }

        if($request->has('subFilter')) {

            $stockMovementRepository->subFilter('product,'.$request->subFilter);
        }

        if($stockMovement = $stockMovementRepository->getResultado()) {   

            return new StockMovementResource($stockMovement);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /************************************************************************************/
    public function store(StockMovementSaveRequest $request) {

        if($store = $this->stockMovement->create($request->all())) {
            
            return response()->json([ 'stockMovement' => $store, 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }

    /************************************************************************************/
    public function show(string $stockMovement)  {

        return new StockMovementResource($this->stockMovement->with('product')->findOrFail($stockMovement));
    }

    /************************************************************************************/
    public function update(StockMovementSaveRequest $request, string $stockMovement) {

        if($update = $this->stockMovement->find($stockMovement)) {

            if($update->update($request->all())) {

                return response()->json([ 'stockMovement' => $update, 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);
    }

    /************************************************************************************/
    public function destroy(string $stockMovement) {
        
        if($destroy = $this->stockMovement->find($stockMovement)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}
