<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category', 'tags')->paginate(9);

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {

        //abort_if(! auth()->user()->tokenCan('categories-show'), 403);

        return new ProductResource(Product::with('category', 'tags')->find($product->id));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = Str::uuid() . '.' . $file->extension();
            $file->storeAs('products', $name, 'public');
            $data['photo'] = $name;
        }

        $product = Product::create($data);
        $product->tags()->sync($request->input('tags', []));

        return new ProductResource($product);
    }

    public function update(StoreProductRequest $request, Product $product)
    {    //Con el category buscara con la id la categoria en concreto
        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Product $product){

        $product->tags()->detach();
        $product->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT); //Respuesta hhtp constante sin contenido

        //return response()->noContent();
    }
    public function ProductByCategory($category_id){
        $category = Category::with('products')->find($category_id);
        $products = $category->products;
        return ProductResource::collection($products);
    }

    public function ProductByTag($tag_id){
        $tag = Tag::with('products')->find($tag_id);
        $products = $tag->products;
        return ProductResource::collection($products);
    }

}
