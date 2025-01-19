<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminUpdate extends Component
{
    public Product $product;

    public ?int $categoryId = null;
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public ?int $brand = null;
    public bool $active = true;

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
    public function categories()
    {
        return Category::query()->orderByDesc('id')->get();
    }

    public function update()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $this->slug = Str::slug($this->name);

            $this->product->category_id = $this->categoryId;
            $this->product->name = $this->name;
            $this->product->slug = $this->slug;
            $this->product->description = $this->description;
            $this->product->brand = $this->brand;
            $this->product->active = $this->active;
            $this->product->save();

            DB::commit();

            return $this->js('alert("Produto editada com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        $this->categoryId = $this->product->category_id;
        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->brand = $this->product->brand;
        $this->active = $this->product->active;

        $categories = [];
        $brands = [];

        foreach ($this->categories as $category):
            if ($category->brand) {
                $brands[] = $category;
            }

            if (! $category->brand) {
                $categories[] = $category;
            }
        endforeach;

        return view('livewire.product.admin-update', [
            'categories' => $categories,
            'brands' => $brands,
        ])->layout('components.layouts.admin');
    }
}
