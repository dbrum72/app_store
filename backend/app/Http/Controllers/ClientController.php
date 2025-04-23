<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\ClientSaveRequest;
use App\Http\Resources\ClientResource;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller {

    public function __construct(Client $client) {

        $this->client = $client;
    }

    /********************************************************************************************************/
    
    public function index(Request $request) {
        
        $clientRepository = new ClientRepository($this->client);

        if($request->has('atributos')) {

            $clientRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $clientRepository->selectWith($request->with);
        }        

        if($request->has('filter')) {

            $clientRepository->filter($request->filter);
        }

        if($request->has('extendedFilter')) {

            $clientRepository->extendedFilter($request->extendedFilter);
        }

        if($request->has('sort')) {

            $clientRepository->sort($request->sort);
        }

        if($clients = $clientRepository->getResultado()) {   

            return new ClientResource($clients);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }


    /************************************************************************************/
    public function store(ClientSaveRequest $request) {

        if($store = $this->client->create($request->all())) {
            
            return response()->json([ 'client' => $store, 'errors' => [], 'msg' => 'Registro criado com sucesso!' ], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }


    /********************************************************************************************************/
    
    public function update(ClientSaveRequest $request, $client) {
        
        if($update = $this->client->find($client)) {            

            if($update->update($request->all())) {

                return response()->json([ 'client' => $update, 'errors' => [], 'msg' => 'Registro atualizado com sucesso!' ], 201);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);        
    }

    /********************************************************************************************************/

    public function show($client) {

        return new ClientResource($this->client->with('addresses')->findOrFail($client));
    }

    /********************************************************************************************************/
    
    public function destroy($client) {

        if($destroy = $this->client->find($client)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }
}