<?php

namespace App\Livewire\Product;

use App\Repositories\ProductRepository;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminIndex extends Component
{
    public ?int $searchByID = null;
    public ?string $searchByName = null;
    public array $filters = [];
    public array $columns = ['id', 'name'];
    public bool $filter = false;

    #[Computed()]
    public function products()
    {
        if ($this->filter and $this->searchByID) {
            $this->filters['id'] = $this->searchByID;
        }

        if ($this->filter and $this->searchByName) {
            $this->filters['name'] = $this->searchByName;
        }

        if (!$this->searchByID and !$this->searchByName) {
            $this->filter = false;
            $this->filters = [];
        }

        return (new ProductRepository)->getAll($this->filters, 5, $this->columns);
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
