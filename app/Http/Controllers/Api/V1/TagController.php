<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::with('products')->paginate(9);

        return TagResource::collection($tags);
    }

    public function show(Tag $tag)
    {

        //abort_if(! auth()->user()->tokenCan('categories-show'), 403);

        return new TagResource(Tag::with('products')->find($tag->id));
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->all());
        $tag->products()->attach($request->input('products', []));
        return new TagResource($tag);
    }

    public function update(StoreTagRequest $request, Tag $tag)
    {    //Con el category buscara con la id la categoria en concreto
        $tag->update($request->validated());

        return new TagResource($tag);
    }

    public function destroy(Tag $tag){
        $tag->products()->detach();
        $tag->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT); //Respuesta hhtp constante sin contenido

        //return response()->noContent();
    }


}
