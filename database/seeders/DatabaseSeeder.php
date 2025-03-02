<?php

namespace Database\Seeders;

use App\Enums\UserLevel;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Models\User;
use App\Models\Variation;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create([
            'name' => 'Cliente 1',
            'email' => 'usr@test.c',
            'level' => UserLevel::Costumer,
        ]);
        User::factory(1)->create([
            'name' => 'Administrador 1',
            'email' => 'adm@test.c',
            'level' => UserLevel::Admin,
        ]);

        $categories = ['Roupa', 'Acessorio', 'Calcado'];

        foreach ($categories as $key => $category):
            if (! Category::where('name', $category)->exists()) {
                Category::factory()->create([ 'name' => $category, 'parent' => null ]);
            }
        endforeach;

        // Category::factory(10)->create();

        Category::all()->each(function(Category $category) {
        //     if ($category->id > 5) {
        //         $category->parent = random_int(1, 5);
        //         $category->save();
        //     }

        //     $qntProduct = random_int(1, 10);
            $qntProduct = random_int(1, 3);

        //     Product::factory()->count($qntProduct)->create(['category_id' => random_int(1000, 1003)]);
            Product::factory()->count($qntProduct)->create(['category_id' => 1000]);
        });

        // Product::factory(3)->create();

        // for ($i = 0; $i <= 7; $i++):
        //     $typeVariation = 'color';

        //     $valueVariations = ['Azul', 'Vermelho', 'Preto', 'Branco', 'Laranja', 'Cinza', 'Verde', 'Amarelo'];
        //     $codeVariations = ['#0000FF', '#FF0000', '#000000', '#FFFFFF', '#FFA500', '#646464', '#00FF00', '#FFFF00'];

        //     $valueVariation = $valueVariations[$i];
        //     $codeVariation = $codeVariations[$i];

        //     if (! Variation::where('type', $typeVariation)->where('value', $valueVariation)->exists()) {
        //         Variation::factory()->create([
        //             'type' => $typeVariation,
        //             'value' => $valueVariation,
        //             'code' => $codeVariation,
        //         ]);
        //     }
        // endfor;

        // for ($i = 0; $i <= 4; $i++):
        //     $typeVariation = 'size';

        //     $sizeVariations = ['PP', 'P', 'M', 'G', 'GG'];
        //     $codeVariations = ['1', '2', '3', '4', '5'];

        //     $valueVariation = $sizeVariations[$i];
        //     $codeVariation = $codeVariations[$i];

        //     if (! Variation::where('type', $typeVariation)->where('value', $valueVariation)->exists()) {
        //         Variation::factory()->create([
        //             'type' => $typeVariation,
        //             'value' => $valueVariation,
        //             'code' => $codeVariation,
        //         ]);
        //     }
        // endfor;

        // Product::all()->each(function(Product $product) {
        //     $skusCount = random_int(0, 4);

        //     for ($i = 0; $i <= $skusCount; $i++):
        //         $variation_id_1 = Variation::query()
        //             ->inRandomOrder()
        //             ->where('type', 'color')
        //             ->first();

        //         $variation_id_2 = Variation::query()
        //             ->inRandomOrder()
        //             ->where('type', 'size')
        //             ->first();

        //         Sku::factory()->create([
        //             'product_id' => $product->id,
        //             'variation_id_1' => $variation_id_1,
        //             'variation_id_2' => $variation_id_2,
        //         ]);
        //     endfor;
        // });
    }
}
