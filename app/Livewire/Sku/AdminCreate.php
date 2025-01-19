<?php

namespace App\Livewire\Sku;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Sku;
use App\Models\Variation;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminCreate extends Component
{
    use WithFileUploads;

    public ?Sku $sku = null;
    public ?ProductImage $productImage = null;

    public ?int $productId = null;
    public ?int $skuId = null;
    public int|float|null $price = null;
    public int|float|null $costPrice = null;
    public int|float|null $discountPrice = null;
    public ?int $variationId1 = null;
    public ?int $variationId2 = null;
    public int $stock = 0;
    public bool $active = true;
    public int|float|null $width = null;
    public int|float|null $height = null;
    public int|float|null $length = null;
    public int|float|null $weight = null;
    public ?string $image1Preview = null;
    public ?string $image2Preview = null;
    public ?string $image3Preview = null;
    public ?string $image4Preview = null;
    public ?string $image5Preview = null;
    public ?object $image1 = null;
    public ?object $image2 = null;
    public ?object $image3 = null;
    public ?object $image4 = null;
    public ?object $image5 = null;

    public $imagePreview1 = null;

    protected function rules()
    {
        return [
            'productId' => 'required',
            'variationId1' => 'required',
            'variationId2' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'productId.required' => 'O campo produto é obrigatório',
            'variationId1.required' => 'O campo cor é obrigatório',
            'variationId2.required' => 'O campo tamanho é obrigatório',
        ];
    }

    #[Computed()]
    public function products()
    {
        return Product::query()
            ->where('active', true)
            ->select('id', 'name')
            ->orderByDesc('id')
            ->get();
    }

    #[Computed()]
    public function colors()
    {
        return Variation::query()
            ->where('type', 'color')
            ->select('id', 'value', 'type', 'code')
            ->orderByDesc('code')
            ->get();
    }

    #[Computed()]
    public function sizes()
    {
        return Variation::query()
            ->where('type', 'size')
            ->select('id', 'value', 'type')
            ->get();
    }

    public function store()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $sku = Sku::create([
                'product_id' => $this->productId,
                'price' => $this->price  * 100,
                'cost_price' => $this->costPrice  * 100,
                'discount_price' => $this->discountPrice  * 100,
                'variation_id_1' => $this->variationId1,
                'variation_id_2' => $this->variationId2,
                'stock' => $this->stock,
                'active' => $this->active,
                'width' => $this->width,
                'height' => $this->height,
                'length' => $this->length,
                'weight' => $this->weight,
                'image1' => $this->image1,
                'image2' => $this->image2,
                'image3' => $this->image3,
                'image4' => $this->image4,
                'image5' => $this->image5,
            ]);

            DB::commit();

            $this->sku = $sku;

            return $this->js('alert("Sku criado com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    private function storageImgSku(int $skuId)
    {
        $imageURL = null;

        if ($skuId === 1 and $this->image1) {
            $path = 'products/product-' . $this->sku->product_id;

            $name = '1-' . $this->sku->variation_id_1 . '.' . $this->image1->extension();

            $this->image1->storeAs($path, $name, 'public');

            $imageURL = 'storage/' . $path . '/' . $name;
        }

        if ($skuId === 2 and $this->image2) {
            $path = 'products/product-' . $this->sku->product_id;

            $name = '2-' . $this->sku->variation_id_1 . '.' . $this->image2->extension();

            $this->image2->storeAs($path, $name, 'public');

            $imageURL = 'storage/' . $path . '/' . $name;
        }

        if ($skuId === 3 and $this->image3) {
            $path = 'products/product-' . $this->sku->product_id;

            $name = '3-' . $this->sku->variation_id_1 . '.' . $this->image3->extension();

            $this->image3->storeAs($path, $name, 'public');

            $imageURL = 'storage/' . $path . '/' . $name;
        }

        if ($skuId === 4 and $this->image4) {
            $path = 'products/product-' . $this->sku->product_id;

            $name = '4-' . $this->sku->variation_id_1 . '.' . $this->image4->extension();

            $this->image4->storeAs($path, $name, 'public');

            $imageURL = 'storage/' . $path . '/' . $name;
        }

        if ($skuId === 5 and $this->image5) {
            $path = 'products/product-' . $this->sku->product_id;

            $name = '5-' . $this->sku->variation_id_1 . '.' . $this->image5->extension();

            $this->image5->storeAs($path, $name, 'public');

            $imageURL = 'storage/' . $path . '/' . $name;
        }

        return $imageURL;
    }

    public function storeImage()
    {
        $image1 = $this->storageImgSku(1);
        $image2 = $this->storageImgSku(2);
        $image3 = $this->storageImgSku(3);
        $image4 = $this->storageImgSku(4);
        $image5 = $this->storageImgSku(5);

        DB::beginTransaction();

        try {
            if ($this->productImage) {
                $this->productImage->image_1 = $image1 ?? $this->image1Preview;
                $this->productImage->image_2 = $image2 ?? $this->image2Preview;
                $this->productImage->image_3 = $image3 ?? $this->image3Preview;
                $this->productImage->image_4 = $image4 ?? $this->image4Preview;
                $this->productImage->image_5 = $image5 ?? $this->image5Preview;
                $this->productImage->save();
            } else {
                ProductImage::create([
                    'product_id' => $this->sku->product_id,
                    'variation_id' => $this->variationId1,
                    'image_1' => $image1 ?? $this->image1Preview,
                    'image_2' => $image2 ?? $this->image2Preview,
                    'image_3' => $image3 ?? $this->image3Preview,
                    'image_4' => $image4 ?? $this->image4Preview,
                    'image_5' => $image5 ?? $this->image5Preview,
                ]);
            }

            DB::commit();

            return $this->js('alert("Imagem(s) criada(s) com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        if ($this->sku) {
            $this->productImage = ProductImage::query()
                                    ->where('product_id', $this->sku->product_id)
                                    ->where('variation_id', $this->variationId1)
                                    ->first();

            if ($this->productImage) {
                $this->image1Preview = $this->productImage->image_1;
                $this->image2Preview = $this->productImage->image_2;
                $this->image3Preview = $this->productImage->image_3;
                $this->image4Preview = $this->productImage->image_4;
                $this->image5Preview = $this->productImage->image_5;
            }
        }

        return view('livewire.sku.admin-create', [
            'products' => $this->products,
            'colors' => $this->colors,
            'sizes' => $this->sizes,
        ])->layout('components.layouts.admin');
    }
}
