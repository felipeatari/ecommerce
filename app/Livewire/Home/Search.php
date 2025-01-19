<?php

namespace App\Livewire\Home;

use App\Models\Product;
use App\Models\ProductImage;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Search extends Component
{
    #[Computed()]
    public function products()
    {
        $products = [];

        $product = Product::query()
            // ->inRandomOrder()
            ->orderByDesc('id')
            ->get();

        foreach ($product as $i => $item):
            foreach ($item->skus()->inRandomOrder()->get() as $sku):
                $productImage = ProductImage::query()
                    ->where('product_id', $sku->product_id)
                    ->where('variation_id', $sku->variation_id_1)
                    ->first();

                    if ($productImage) {
                        $sku->price /= 100;
                        $sku->productName = $item->name;
                        $sku->productImage = $productImage->image_1;

                        $products[$i] = $sku;
                    }
            endforeach;
        endforeach;

        return $products;
    }

    public function render()
    {
        return view('livewire.home.search', [
            'products' => $this->products,
        ]);
    }
}
