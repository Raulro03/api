<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->name(),
            'slug' => trim(strtolower(str_replace(' ', '_', $name))),
            'created_at' => Carbon::now(),
        ];
    }
}
