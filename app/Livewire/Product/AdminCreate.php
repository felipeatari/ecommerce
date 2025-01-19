<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminCreate extends Component
{
    public Product $product;

    public ?int $categoryId = null;
    public string $name = '';
    public string $slug = '';
    public ?int $brand = null;
    public string $description = '';
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

    public function store()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $this->slug = Str::slug($this->name);

            Product::create([
                'category_id' => $this->categoryId,
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'brand' => $this->brand,
                'active' => $this->active,
            ]);

            DB::commit();

            return $this->js('alert("Produto criado com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
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

        return view('livewire.product.admin-create', [
            'categories' => $categories,
            'brands' => $brands,
        ])->layout('components.layouts.admin');
    }
}
