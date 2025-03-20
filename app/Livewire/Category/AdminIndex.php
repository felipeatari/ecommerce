<?php

namespace App\Livewire\Category;

use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination;

    public ?int $searchByID = null;
    public ?string $searchByName = null;
    public array $filters = [];
    public array $columns = ['id', 'name'];
    public bool $filter = false;
    public $selectPerPage = [
        5 => 5,
        10 => 10,
        50 => 50
    ];
    public $selectedPerPage = 5;

    public function updating($property)
    {
        if (in_array($property, ['searchByID', 'searchByName', 'selectedPerPage'])) {
            $this->resetPage();
        }
    }

    #[Computed()]
    public function categories()
    {
        if ($this->filter and $this->searchByID) {
            $this->filters['id'] = $this->searchByID;
        } else {
            unset($this->filters['id']);
        }

        if ($this->filter and $this->searchByName) {
            $this->filters['name'] = $this->searchByName;
        } else {
            unset($this->filters['name']);
        }

        $data = (new CategoryService((new CategoryRepository)))->getAll(
            $this->filters,
            $this->selectedPerPage,
            $this->columns
        );

        if ($data['status'] === 'error') return [];

        return $data['data'];
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
