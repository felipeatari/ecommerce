<?php

namespace App\Livewire\Sync;

use Livewire\Attributes\Computed;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategory extends Component
{
    use WithPagination;

    public ?int $searchByID = null;
    public ?int $categoryId = null;
    public ?string $searchByName = null;
    public array $filters = [];
    public array $columns = ['id', 'name'];
    public bool $filter = false;
    public bool $modalSyncCategory = false;

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

    public function actionModalSyncCategory(?int $categoryId = null)
    {
        $this->categoryId = $categoryId;

        $this->modalSyncCategory = !$this->modalSyncCategory;
    }

    public function render()
    {
        return view('livewire.sync.admin-category', [
            'categories' => $this->categories,
        ])->layout('components.layouts.admin');
    }
}
