<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategorySaveRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    public function __construct(Category $category) {

        $this->category = $category;
    }

    /********************************************************************************************************/
    
    public function index(Request $request) {

        $categoryRepository = new CategoryRepository($this->category);

        if($request->has('atributos')) {

            $categoryRepository->selectAtributos($request->atributos);
        }

        if($request->has('with')) {

            $categoryRepository->selectWith($request->with);
        }        

        if($request->has('filter')) {

            $categoryRepository->filter($request->filter);
        }

        if($request->has('sort')) {

            $categoryRepository->sort($request->sort);
        }

        if($categories = $categoryRepository->getResultado()) {

            return new CategoryResource($categories);            
        }

        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }

    /********************************************************************************************************/
    
    public function store(CategorySaveRequest $request) {

        $request->merge(['tree' => $request->name]);
        
        if(!is_null($request->parent_id)) {

            $tree = Category::find($request->parent_id);
            $name = $tree->name.' -> '.$request->name;

            do {                
                if(!is_null($tree->parent_id)) {
                    $tree = $tree->find($tree->parent_id);
                    $name = $tree->name . '/' . $name;                    
                }
            }
            while(!is_null($tree->parent_id));

            $request->merge(['tree' => $name]);
        }
        
        if($store = $this->category->create($request->all())) {

            return response()->json([ 'category' => $store, 'errors' => [], 'msg' => 'Registro criado com sucesso!'], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }

    /********************************************************************************************************/

    public function update(CategorySaveRequest $request, $category) {
        
        $request->merge(['tree' => $request->name]);
        
        if($update = $this->category->find($category)) {
            
            if(!is_null($request->parent_id)) {

                $tree = Category::find($request->parent_id);
                $name = $tree->name.'/'.$request->name;
    
                do {                
                    if(!is_null($tree->parent_id)) {
                        $tree = $tree->find($tree->parent_id);
                        $name = $tree->name . '/' . $name;                    
                    }
                }
                while(!is_null($tree->parent_id));
    
                $request->merge(['tree' => $name]);
            }
            
            if($update->update($request->all())) {

                return response()->json([ 'category' => $update, 'errors' => [], 'msg' => 'Registro atualizado com sucesso!'], 200);
            }       

            return response()->json(['errors' => ['error' => 'Erro ao gravar o registro']], 404);
        }

        return response()->json(['errors' => ['error' => 'O registro não foi localizado.']], 404);
    }

    /********************************************************************************************************/

    public function show($category) {

        return new CategoryResource($this->category->findOrFail($category));
    }

    /********************************************************************************************************/

    public function destroy($category) {

        if($destroy = $this->category->find($category)) {      
            
            if($destroy->delete()) {

                return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
            }
            
            return response()->json([ 'errors' => ['error' => 'Erro ao excluir o registro']], 404);
        }

        return response()->json(['errors' => ['erro' => 'O registro não foi localizado.']], 404);
    }

    /********************************************************************************************************/

    public function getparentTree($id) {

        if($category = $this->category->find($id)) { 

            $tree = $category->name;

            do {
                if(!is_null($category->parent_id)) {
                    $category = $this->category->find($category->parent_id);
                    $tree = $category->name . ' -> ' . $tree;
                }
            }
            while(!is_null($category->parent_id));

            return $tree;
        } 
        
        return response()->json(['errors' => ['error' => 'Nenhum registro localizado.']], 404);
    }
}
