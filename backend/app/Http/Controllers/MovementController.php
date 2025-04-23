<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Repositories\MovementRepository;
use App\Http\Requests\MovementSaveRequest;
use App\Http\Resources\MovementResource;
use Illuminate\Http\Request;

class MovementController extends Controller {

    public function __construct(Movement $movement) {

        $this->movement = $movement;
    }

    /************************************************************************************/
    public function index(Request $request) {

        $movementRepository = new MovementRepository($this->movement);

        if($request->has('atributos')) {

            $movementRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $movementRepository->selectWith($request->with);
        }

        if($request->has('filter')) {

            $movementRepository->filter($request->filter);
        }

        if($request->has('extendedFilter')) {

            $movementRepository->extendedFilter($request->extendedFilter);
        }

        if($request->has('sort')) {

            $movementRepository->sort($request->sort);
        }

        if($movement = $movementRepository->getResultado()) {   

            return new MovementResource($movement);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /************************************************************************************/
    public function store(MovementSaveRequest $request) {

        if($store = $this->movement->create($request->all())) {
            
            return response()->json([ 'movement' => $store, 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }

    /************************************************************************************/
    public function show(string $movement)  {

        return new MovementResource($this->movement->with('product')->findOrFail($movement));
    }

    /************************************************************************************/
    public function update(MovementSaveRequest $request, string $movement) {

        if($update = $this->movement->find($movement)) {

            if($update->update($request->all())) {

                return response()->json([ 'movement' => $update, 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);
    }

    /************************************************************************************/
    public function destroy(string $movement) {
        
        if($destroy = $this->movement->find($movement)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}
