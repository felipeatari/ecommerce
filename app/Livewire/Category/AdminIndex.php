<?php

namespace App\Livewire\Category;

use App\Jobs\SyncCategoryJop;
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
    public ?int $categoryId = null;
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

        $data = app(CategoryService::class)->getAll(
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

    public function confirmSyncCategory()
    {
        SyncCategoryJop::dispatch($this->categoryId);

        $this->modalSyncCategory = !$this->modalSyncCategory;
    }

    public function render()
    {
        return view('livewire.category.admin-index', [
            'categories' => $this->categories,
        ])->layout('components.layouts.admin');
    }
}
