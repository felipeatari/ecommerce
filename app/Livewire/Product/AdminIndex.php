<?php

namespace App\Livewire\Product;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
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
    public function products()
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

        $data = (new ProductService((new ProductRepository)))->getAll(
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
        return view('livewire.product.admin-index', [
            'products' => $this->products,
        ])->layout('components.layouts.admin');
    }
}
