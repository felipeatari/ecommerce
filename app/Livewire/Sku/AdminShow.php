<?php

namespace App\Livewire\Sku;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Sku;
use App\Repositories\SkuRepository;
use App\Services\SkuService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminShow extends Component
{
    public Sku $sku;

    public ?int $variationId = null;
    public ?string $image1Preview = null;
    public ?string $image2Preview = null;
    public ?string $image3Preview = null;
    public ?string $image4Preview = null;
    public ?string $image5Preview = null;

    public bool $statusModalDelete = false;

    #[Computed()]
    public function productImage()
    {
        return ProductImage::query()
                    ->where('product_id', $this->sku->product_id)
                    ->where('variation_id', $this->sku->variation_id_1)
                    ->first();
    }

    public function modalDelete()
    {
        $this->statusModalDelete = !$this->statusModalDelete;
    }

    public function destroy()
    {
        $data = (new SkuService(new SkuRepository))->remove($this->sku->id);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.sku.index');
    }


    public function render()
    {
        if ($this->productImage) {
            $this->image1Preview = $this->productImage->image_1;
            $this->image2Preview = $this->productImage->image_2;
            $this->image3Preview = $this->productImage->image_3;
            $this->image4Preview = $this->productImage->image_4;
            $this->image5Preview = $this->productImage->image_5;
        }

        return view('livewire.sku.admin-show', [
            'productImage' => $this->productImage,
        ])->layout('components.layouts.admin');
    }
}
