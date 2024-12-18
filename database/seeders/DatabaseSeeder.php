<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
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

        $categories->each(function ($category) {
            $category->products()->saveMany(
                Product::factory(2)->make()
            );
        });

        // Crear 10 tags
        $tags = Tag::factory(4)->create();

        // Crear 5 productos y vincularlos con tags
        Product::factory(5)->create()->each(function ($product) use ($tags) {
            // Seleccionar un subconjunto aleatorio de tags
            $randomTags = $tags->random(2);

            // Vincular el producto con los tags seleccionados
            $product->tags()->attach($randomTags);
        });

        /*$user = User::create([
            'name' => 'Raul',
            'email' => 'raul@email.es',
            'password' => bcrypt('1234')
        ]);
        $token = $user->createToken('developer-access', ['categories-list'])->plainTextToken;

        echo "{$token}";*/

       /* $products->each(function ($product) {
            $product->tags()->attach([rand(1,20), rand(1,20)]);
        });*/

    }
}
