<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory(10)->create(['name' => 'Test User', 'email' => 'test@example.com',]);

        Category::factory(6)->create();

        $categories = Category::all();

        $products = $categories->each(function ($category) {
            $category->products()->saveMany(
                Product::factory(2)->make()
            );
        });



        $products->each(function ($product) {
            $product->tags()->attach([rand(1,20), rand(1,20)]);
        });

    }
}
