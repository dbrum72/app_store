<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserSaveRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function __construct(User $user) {

        $this->user = $user;
    }

    /********************************************************************************************************/
    
    public function index(Request $request) {
        
        $userRepository = new UserRepository($this->user);

        if($request->has('atributos')) {

            $userRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $userRepository->selectWith($request->with);
        }        

        if($request->has('filter')) {

            $userRepository->filter($request->filter);
        }

        if($request->has('extendedFilter')) {

            $userRepository->extendedFilter($request->extendedFilter);
        }

        if($request->has('sort')) {

            $userRepository->sort($request->sort);
        }

        if($users = $userRepository->getResultado()) {   

            return new UserResource($users);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }


    /************************************************************************************/
    public function store(UserSaveRequest $request) {

        if($store = $this->user->create($request->all())) {
            
            return response()->json([ 'user' => $store, 'errors' => [], 'msg' => 'Registro criado com sucesso!' ], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }


    /********************************************************************************************************/
    
    public function update(UserSaveRequest $request, $user) {
        
        if($update = $this->user->find($user)) {            

            if($update->update($request->all())) {

                return response()->json([ 'user' => $update, 'errors' => [], 'msg' => 'Registro atualizado com sucesso!' ], 201);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);        
    }

    /********************************************************************************************************/

    public function show($user) {

        return new UserResource($this->user->with('addresses')->findOrFail($user));
    }

    /********************************************************************************************************/
    
    public function destroy($user) {

        if($destroy = $this->user->find($user)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}