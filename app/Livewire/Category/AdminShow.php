<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminShow extends Component
{
    public Category $category;

    public bool $statusModalDelete = false;

    public function parent(?int $parent)
    {
        if (! $parent) {

            return 'Não';
        }

        $category = Category::find($parent);

        if (! $category) {

            return 'Não';
        }

        return $category->name;
    }

    public function modalDelete()
    {
        $this->statusModalDelete = !$this->statusModalDelete;
    }

    public function destroy()
    {
        $data = (new CategoryService(new CategoryRepository))->delete($this->category->id);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.category.index');
    }

    public function render()
    {
        return view('livewire.category.admin-show')->layout('components.layouts.admin');
    }
}
