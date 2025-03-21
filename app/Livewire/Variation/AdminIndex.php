<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
use App\Repositories\VariationRepository;
use App\Services\VariationService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination;

    public ?int $searchByID = null;
    public ?string $searchByType = null;
    public $selectType = [
        'size' => 'Tamanho',
        'color' => 'Cor',
    ];
    public ?string $searchByValue = null;
    public array $filters = [];
    public array $columns = ['id', 'type', 'value'];
    public bool $filter = false;
    public $selectPerPage = [
        5 => 5,
        10 => 10,
        50 => 50
    ];
    public $selectedPerPage = 5;

    public function updating($property)
    {
        if (in_array($property, ['searchByID', 'searchByType', 'searchByValue', 'selectedPerPage'])) {
            $this->resetPage();
        }
    }

    #[Computed()]
    public function variations()
    {
        if ($this->filter and $this->searchByID) {
            $this->filters['id'] = $this->searchByID;
        } else {
            unset($this->filters['id']);
        }

        if ($this->filter and $this->searchByType) {
            $this->filters['type'] = $this->searchByType;
        } else {
            unset($this->filters['type']);
        }

        if ($this->filter and $this->searchByValue) {
            $this->filters['value'] = $this->searchByValue;
        } else {
            unset($this->filters['value']);
        }

        $data = (new VariationService((new VariationRepository)))->getAll(
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
        return view('livewire.variation.admin-index', [
            'variations' => $this->variations,
        ])->layout('components.layouts.admin');
    }
}
