<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminUpdate extends Component
{
    public Category $category;
    public string $name = '';
    public ?int $parent = null;

    protected function rules()
    {
        return ['name' => 'required'];
    }

    protected function messages()
    {
        return ['name.required' => 'O campo nome é obrigatório'];
    }

    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

    public function update()
    {
        $this->validate();

        $data = (new CategoryService(new CategoryRepository))->update($this->category->id, [
            'name' => $this->name,
            'parent' => $this->parent,
        ]);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.category.show', ['category' => $this->category->id]);
    }

    public function render()
    {
        $this->name = $this->category->name;
        $this->parent = $this->category->parent;

        return view('livewire.category.admin-update', [
            'categories' => $this->categories
        ])->layout('components.layouts.admin');
    }
}
