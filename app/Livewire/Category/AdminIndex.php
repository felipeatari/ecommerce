<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
class AdminIndex extends Component
{
    // use WithPagination, WithoutUrlPagination;

    private Category $category;
    public ?int $searchID = null;
    public ?string $searchName = null;
    public array $filters = [];
    public array $columns = ['id', 'name'];
    public bool $filter = false;

    #[Computed()]
    public function categories()
    {
        if ($this->filter and $this->searchID) {
            $this->filters['id'] = $this->searchID;
        }

        if ($this->filter and $this->searchName) {
            $this->filters['name'] = $this->searchName;
        }

        if (!$this->searchID and !$this->searchName) $this->filters = [];

        return (new CategoryRepository)->getAll($this->filters, 5, $this->columns);
    }

    public function search()
    {
        $this->filter = true;
    }

    public function render()
    {
        return view('livewire.category.admin-index', [
            'categories' => $this->categories,
        ])->layout('components.layouts.admin');
    }
}
