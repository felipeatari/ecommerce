<?php

namespace App\Livewire\Home;

use App\Livewire\Cart\Index as CartIndex;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Sku;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Index extends Component
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

    public function addItemCart($product)
    {
        $addCart = (new CartIndex)->addCart(json_encode($product));

        $this->dispatch('add-cart', session('totalItemsCart'));

        return $addCart;
    }

    public function render()
    {
        return view('livewire.home.index', [
            'products' => $this->products,
        ])->title('Página Home');
    }
}
