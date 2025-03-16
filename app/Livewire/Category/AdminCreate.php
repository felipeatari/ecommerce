<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminCreate extends Component
{
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

    public function store()
    {
        $this->validate();

        $data = (new CategoryService(new CategoryRepository))->create([
            'name' => $this->name,
            'parent' => $this->parent,
        ]);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return $this->js('alert("Categoria criada com sucesso.")');
    }

    public function render()
    {
        return view('livewire.category.admin-create', [
            'categories' => $this->categories
        ])->layout('components.layouts.admin');
    }
}
