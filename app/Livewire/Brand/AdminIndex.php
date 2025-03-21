<?php

namespace App\Livewire\Brand;

use App\Repositories\BrandRepository;
use App\Services\BrandService;
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

    public $selectedPerPage = 5;

    public function updating($property)
    {
        if (in_array($property, ['searchByID', 'searchByName', 'selectedPerPage'])) {
            $this->resetPage();
        }
    }

    #[Computed()]
    public function brands()
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

        $data = (new BrandService((new BrandRepository)))->getAll(
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
        return view('livewire.brand.admin-index', [
            'brands' => $this->brands,
        ])->layout('components.layouts.admin');
    }
}
