<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminCreate extends Component
{
    public string $name = '';
    public int $parent = 0;
    public bool $brand = false;

    protected function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
        ];
    }

    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

    public function store()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            Category::create([
                'name' => $this->name,
                'parent' => $this->parent,
                'brand' => $this->brand,
            ]);

            DB::commit();

            return $this->js('alert("Categoria criada com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.category.admin-create', [
            'categories' => $this->categories
        ])->layout('components.layouts.admin');
    }
}
