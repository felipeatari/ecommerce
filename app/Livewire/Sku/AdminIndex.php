<?php

namespace App\Livewire\Sku;

use App\Models\Sku;
use App\Repositories\SkuRepository;
use App\Services\SkuService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination;

    public ?int $searchByID = null;
    public ?string $searchByProduct= null;
    public ?string $searchByVariation1 = null;
    public ?string $searchByVariation2 = null;
    public array $filters = [];
    public array $columns = [];
    public bool $filter = false;

    public $selectedPerPage = 5;

    public function updating($property)
    {
        if (in_array($property, [
            'searchByID', 'searchByProduct', 'searchByVariation1', 'searchByVariation2'])) {
            $this->resetPage();
        }
    }

    #[Computed()]
    public function skus()
    {
        if ($this->filter and $this->searchByID) {
            $this->filters['id'] = $this->searchByID;
        } else {
            unset($this->filters['id']);
        }

        if ($this->filter and $this->searchByProduct) {
            $this->filters['product'] = $this->searchByProduct;
        } else {
            unset($this->filters['product']);
        }

        if ($this->filter and $this->searchByVariation1) {
            $this->filters['variation_1'] = $this->searchByVariation1;
        } else {
            unset($this->filters['variation_1']);
        }

        if ($this->filter and $this->searchByVariation2) {
            $this->filters['variation_2'] = $this->searchByVariation2;
        } else {
            unset($this->filters['variation_2']);
        }

        $data = (new SkuService(new SkuRepository))->getAll(
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
        return view('livewire.sku.admin-index', [
            'skus' => $this->skus,
        ])->layout('components.layouts.admin');
    }
}
