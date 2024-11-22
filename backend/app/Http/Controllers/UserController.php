<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserUpdateRequest;
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

        if($users = $userRepository->getResultado()) {   

            return new UserResource($users);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }


    /********************************************************************************************************/
    
    public function update(UserUpdateRequest $request, $user) {
        
        if($update = $this->user->find($user)) {            

            if($update->update($request->all())) {

                return response()->json([ 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);        
    }

    /********************************************************************************************************/

    public function show($user) {

        return new UserResource($this->user->findOrFail($user));
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