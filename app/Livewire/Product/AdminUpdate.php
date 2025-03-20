<?php

namespace App\Livewire\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminUpdate extends Component
{
    public Product $product;

    public ?int $categoryId = null;
    public ?int $brandId = null;
    public string $name = '';
    public string $slug = '';
    public string $description = '';

    protected function rules()
    {
        return [
            'categoryId' => 'required',
            'name' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'categoryId.required' => 'O campo categoria é obrigatório',
            'name.required' => 'O campo nome é obrigatório',
        ];
    }

    #[Computed()]
    public function category()
    {
        return Category::query()
            ->orderByDesc('id')
            ->pluck('name', 'id')
            ->toArray();
    }

    #[Computed()]
    public function brand()
    {
        return Brand::query()
            ->orderByDesc('id')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function update()
    {
        $this->validate();

        $data = (new ProductService(new ProductRepository))->update($this->product->id, [
            'category_id' => $this->categoryId,
            'brand_id' => $this->brandId,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.product.show', ['product' => $this->product->id]);
    }

    public function render()
    {
        $this->categoryId = $this->product->category_id;
        $this->brandId = $this->product->brand_id;
        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->active = $this->product->active;

        return view('livewire.product.admin-update', [
            'category' => $this->category(),
            'brand' => $this->brand(),
        ])->layout('components.layouts.admin');
    }
}
