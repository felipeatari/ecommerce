<?php

namespace App\Livewire\Home;

use App\Livewire\Cart\Index as CartIndex;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Sku;
use App\Services\ShippingMelhorEnvioService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Component;

use function PHPUnit\Framework\returnSelf;
use function Termwind\render;

class Show extends Component
{
    public ?Product $product;

    public string|int|null $skuId = null;
    public string|int|null $productId = null;
    public ?string $slug = null;

    public array $selecteSizes = [];

    public array $addProductCart = [];
    public ?string $selectedColor = '';
    public ?string $selectedSize = '';
    public array $selectedSizes = [];
    public int|float $productPrice = 0;
    public array $variations = [];
    public int $stock = 0;
    public string $zipCode = '';
    public array $shippingCalculation = [];
    public bool $modalShippingCalculation = false;
    public $productImage = null;
    public ?int $selectedColorId = null;
    public ?int $selectedImageId = null;
    public ?string $selectedImageURL = null;

    public function mount(string $slug, Request $request)
    {
        $this->skuId = $request->get('sku');
        $this->selectedColor = $request->get('cor');
        $this->selectedSize = $request->get('tam');
        $this->slug = $slug;

        $this->product = Product::query()
            ->where('slug', $slug)
            ->first();
    }

    public function selectColor(array $sku)
    {
        return $this->mountShowProduct($sku[0]);
    }

    public function selectSize(string $size)
    {
        $this->selectedSize = $size;
    }

    public function mountShowProduct(array $sku)
    {
        $this->addProductCart = [];

        foreach ($this->productImage as $image):
            if ($image->variation_id !== $sku['colorId']) continue;

            if (is_null($this->selectedImageURL)) {
                $this->selectedImageId = $image->id;
                $this->selectedImageURL = $image->image_1;
            }
        endforeach;

        if (in_array($this->selectedSize, $this->selectedSizes[$sku['sku_id']])) {
            $this->selectedSize = $sku['size'];
            $this->productPrice = $sku['price'];
            $this->stock = $sku['stock'];
            $this->selectedColorId = $sku['colorId'];
        }

        $this->addProductCart['id'] = $this->product->id;
        $this->addProductCart['sku_id'] = $sku['sku_id'];
        $this->addProductCart['name'] = $this->product->name;
        $this->addProductCart['price'] = $this->productPrice;
        $this->addProductCart['stock'] = $this->stock;
        $this->addProductCart['weight'] = $sku['weight'];
        $this->addProductCart['width'] = $sku['width'];
        $this->addProductCart['height'] = $sku['height'];
        $this->addProductCart['length'] = $sku['length'];
        $this->addProductCart['color'] = $this->selectedColor;
    }

    #[Computed()]
    public function skus()
    {
        if (! $this->product) return [];

        $skus = $this->product
            ->skus()
            ->get()
            ->each(function (Sku $sku) {
                $productImage = ProductImage::query()
                    ->where('product_id', $sku->product_id)
                    ->where('variation_id', $sku->variation_id_1)
                    ->first();

                if ($productImage) {
                    $this->productImage[] = $productImage;
                }

                $sku->price /= 100;
            });

        if ($this->productImage) {
            $this->productImage = array_unique($this->productImage);
        }

        $this->variations = [];
        $this->selecteSizes = [];

        foreach ($skus as $sku):
            $this->variations[$sku->variation1->value][] = [
                'sku_id' => $sku->id,
                'color' => $sku->variation1->value,
                'codeColor' => $sku->variation1->code,
                'colorId' => $sku->variation_id_1,
                'size' => $sku->variation2->value,
                'codeSize' => $sku->variation2->code,
                'price' => $sku->price,
                'stock' => $sku->stock,
                'weight' => $sku->weight,
                'width' => $sku->width,
                'height' => $sku->height,
                'length' => $sku->length,
            ];

            $this->selecteSizes[$sku->variation2->code][] = [
                $sku->variation2->code => $sku->variation2->value,
                'sku_id' => $sku->id,
                'color' => $sku->variation1->value,
                'codeSize' => $sku->variation2->code,
                'size' => $sku->variation2->value,
                'price' => $sku->price,
                'stock' => $sku->stock,
                'colorId' => $sku->variation_id_1,
            ];

            $this->selectedSizes[$sku->id][] = $sku->variation2->value;
        endforeach;

        ksort($this->selecteSizes);

        return $skus;
    }

    public function addItemCart()
    {
        if ($this->stock === 0) {
            $this->js('alert("Produto sem estoque :(")');

            return;
        }

        if (! $this->selectedSize) {
            $this->js('alert("Selecione um tamanho")');

            return;
        }

        $this->addProductCart['stock'] = $this->stock;
        $this->addProductCart['size'] = $this->selectedSize;
        $this->addProductCart['price'] = $this->productPrice;
        $this->addProductCart['image'] = $this->selectedImageURL;

        $addCart = (new CartIndex)->addCart($this->addProductCart);

        $this->dispatch('add-cart', session('totalItemsCart'));

        return $addCart;
    }

    public function calculateShipping()
    {
        if (! preg_match('/^[\d]{8}$/', $this->zipCode) and ! preg_match('/^[\d]{5}-[\d]{3}$/', $this->zipCode)) return;

        $this->shippingCalculation = [];

        $product = [
            [
                'id' => $this->addProductCart['id'],
                'price_cart' => $this->addProductCart['price'],
                'weight' => $this->addProductCart['weight'],
                'width' => $this->addProductCart['width'],
                'height' => $this->addProductCart['height'],
                'length' => $this->addProductCart['length'],
                'quantity' => 1,
            ]
        ];

        $shipping = (new ShippingMelhorEnvioService)->calculate($this->zipCode, $product);

        foreach ($shipping as $item):
            if (isset($item['error']) and $item['error']) continue;

            $this->shippingCalculation[] = [
                'name' => 'Melhor Envio - ' . $item['name'],
                'price' => $item['price'],
                'delivery_time' => $item['delivery_time']
            ];
        endforeach;

        if (! $this->shippingCalculation) {
            $this->js('alert("Ocorreu um erro ao calcular o frete")');

            return;
        }

        $this->zipCode = '';
        $this->modalShippingCalculation = true;
    }

    public function closeModalShippingCalculation()
    {
        $this->modalShippingCalculation = false;
    }

    public function selectImagem($productImageURL)
    {
        $this->selectedImageURL = $productImageURL;
    }

    public function render()
    {
        if (! $this->product) {
            return view('errors.product404');
        }

        if ($this->skuId) {
            foreach ($this->skus as $i => $sku):
                $sku = $sku->toArray();

                if ($sku['variation1']['value'] != $this->selectedColor) {
                    continue;
                }

                $sku['sku_id'] = $sku['id'];
                $sku['color'] = $sku['variation1']['value'];
                $sku['size'] = $sku['variation2']['value'];
                $sku['colorId'] = $sku['variation_id_1'];

                if (is_null($this->selectedSize)) {
                    $i = 0;
                    foreach ($this->selecteSizes as $sizeItems):
                        if (isset($sizeItems[$i])) {
                            foreach ($sizeItems as $sizeItem):
                                if ($sizeItem['color'] === $this->selectedColor) {
                                    $this->productPrice = $sizeItem['price'];
                                    $this->stock = $sizeItem['stock'];
                                    $this->selectedColorId = $sizeItem['colorId'];

                                    break;
                                }
                            endforeach;
                        }
                        $i++;
                    endforeach;

                    $this->mountShowProduct($sku);
                    break;
                }

                $this->mountShowProduct($sku);
            endforeach;
        }

        if ($this->zipCode) {
            $this->calculateShipping();
        }

        return view('livewire.home.show', [
            'skus' => $this->skus
        ]);
    }
}
