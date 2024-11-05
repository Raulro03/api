<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(){
        return CategoryResource::collection(Category::all());
    }
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = Str::uuid() . '.' . $file->extension();
            $file->storeAs('categories', $name, 'public');
            $data['photo'] = $name;
        }

        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {    //Con el category buscara con la id la categoria en concreto
        $category->update($request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category){
        $category->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT); //Respuesta hhtp constante sin contenido

        //return response()->noContent();
    }



    public function list()
    {
        return CategoryResource::collection(Category::all());
    }


}
