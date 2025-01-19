<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
class AdminIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    public Category $category;

    #[Computed()]
    public function categories()
    {
        return Category::select(['id', 'name'])
            ->orderByDesc('id')
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.category.admin-index', [
            'categories' => $this->categories,
        ])->layout('components.layouts.admin');
    }
}
