<?php

namespace App\Http\Controllers;

use App\Models\ClientAddress;
use App\Http\Requests\ClientAddressSaveRequest;
use App\Http\Resources\ClientAddressResource;
use App\Repositories\ClientAddressRepository;
use Illuminate\Http\Request;

class ClientAddressController extends Controller {

    public function __construct(ClientAddress $clientAddress) {

        $this->clientAddress = $clientAddress;
    }

    /********************************************************************************************************/
    
    public function index(Request $request) {
        
        $clientAddressRepository = new ClientAddressRepository($this->clientAddress);

        if($request->has('atributos')) {

            $clientAddressRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $clientAddressRepository->selectWith($request->with);
        }        

        if($request->has('filter')) {

            $clientAddressRepository->filter($request->filter);
        }

        if($request->has('subFilter')) {

            $clientAddressRepository->subFilter($request->subFilter);
        }

        if($clientAddresss = $clientAddressRepository->getResultado()) {   

            return new ClientAddressResource($clientAddresss);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }


    /************************************************************************************/
    public function store(ClientAddressSaveRequest $request) {

        if($store = $this->clientAddress->create($request->all())) {
            
            return response()->json([ 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }


    /********************************************************************************************************/
    
    public function update(ClientAddressSaveRequest $request, $clientAddress) {
        
        if($update = $this->clientAddress->find($clientAddress)) {            

            if($update->update($request->all())) {

                return response()->json([ 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);        
    }


    public function show($clientAddress) {

        return new ClientAddressResource($this->clientAddress->with('client')->findOrFail($clientAddress));
    }

    /********************************************************************************************************/
    
    public function destroy($clientAddress) {

        if($destroy = $this->clientAddress->find($clientAddress)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}