<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->when($request->is('api/v*/categories*'), function () use ($request) {
                if($request->is('api/v*/categories')){
                    return str($this->description)->limit(20);
                }
                return $this->description;
            }),
            'photo' => $this->when($this->photo, function () use ($request) {
                return $this->photo;
            }),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
