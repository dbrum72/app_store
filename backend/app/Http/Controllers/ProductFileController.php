<?php

namespace App\Http\Controllers;

use App\Models\ProductFile;
use App\Http\Requests\ProductFileStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductFileController extends Controller {

    public function store(ProductFileStoreRequest $request) {

        if ($file = $request->file('file')) {
        
            $nameUnico = str_shuffle(time() . Str::random(10)) . '.' . $file->getClientOriginalExtension();

            if($store = ProductFile::create([
                'name' => $file->getClientOriginalName(),
                'storaged' => $nameUnico,
                'product_id' => $request->product_id
            ])) {
                $file->storeAs('files', $nameUnico, 'public');
            }         
            

            return response()->json([ 'errors' => [], 'msg' => 'Registro criado com sucesso.']);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro.']], 404);
    }

    /********************************************************************************************************/

    public function destroy(ProductFile $product_file) {
        
        if($product_file && $product_file->delete()) {

            Storage::disk('public')->delete('files/'.$product_file->storaged);

            return response()->json([ 'errors' => [], 'msg' => 'Registro removido com sucesso!'], 200);            
        }

        return response()->json(['erro' => 'Impossível excluir os dados. Registro pesquisado não existe'], 404);               
    }
}
