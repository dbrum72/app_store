<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Http\Requests\UserAddressSaveRequest;
use App\Http\Resources\UserAddressResource;
use App\Repositories\UserAddressRepository;
use Illuminate\Http\Request;

class UserAddressController extends Controller {

    public function __construct(UserAddress $userAddress) {

        $this->userAddress = $userAddress;
    }

    /********************************************************************************************************/
    
    public function index(Request $request) {
        
        $userAddressRepository = new UserAddressRepository($this->userAddress);

        if($request->has('atributos')) {

            $userAddressRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $userAddressRepository->selectWith($request->with);
        }        

        if($request->has('filter')) {

            $userAddressRepository->filter($request->filter);
        }

        if($request->has('extendedFilter')) {

            $userAddressRepository->extendedFilter($request->extendedFilter);
        }

        if($userAddresss = $userAddressRepository->getResultado()) {   

            return new UserAddressResource($userAddresss);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }


    /************************************************************************************/
    public function store(UserAddressSaveRequest $request) {

        if($store = $this->userAddress->create($request->all())) {
            
            return response()->json([ 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }


    /********************************************************************************************************/
    
    public function update(UserAddressSaveRequest $request, $userAddress) {
        
        if($update = $this->userAddress->find($userAddress)) {            

            if($update->update($request->all())) {

                return response()->json([ 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);        
    }


    public function show($userAddress) {

        return new UserAddressResource($this->userAddress->with('user')->findOrFail($userAddress));
    }

    /********************************************************************************************************/
    
    public function destroy($userAddress) {

        if($destroy = $this->userAddress->find($userAddress)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}