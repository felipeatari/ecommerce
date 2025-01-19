<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminUpdate extends Component
{
    public Category $category;

    public string $name = '';
    public int $parent = 0;
    public bool $brand;

    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

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

    public function update()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $this->category->name = $this->name;
            $this->category->parent = $this->parent;
            $this->category->brand = $this->brand;
            $this->category->save();

            DB::commit();

            return $this->js('alert("Categoria editada com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        $this->name = $this->category->name;
        $this->parent = $this->category->parent;
        $this->brand = $this->category->brand;

        return view('livewire.category.admin-update', [
            'categories' => $this->categories
        ])->layout('components.layouts.admin');
    }
}
