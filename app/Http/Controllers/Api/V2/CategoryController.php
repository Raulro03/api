<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    /**
     * @OA\Get (
     *     path="/categories",
     *     tags={"Categories"},
     *     summary="Get list all categories",
     *     @OA\Response(
     *      response="200",
     *      description="Succesful operation",
     *     ),
     *     @OA\Response(
     *      response="401",
     *      description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *       response="403",
     *       description="Forbidden",
     *     ),
     * ),
     */
    public function index(){

        abort_if(! auth()->user()->tokenCan('categories-list'), 403);

        return CategoryResource::collection(Cache::rememberForever('categories', function () {
            return Category::all();
        }));
    }

    public function show(Category $category)
    {
        abort_if(! auth()->user()->tokenCan('categories-show-create')
            && ! auth()->user()->tokenCan('categories-list'), 403, 'no va');

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
