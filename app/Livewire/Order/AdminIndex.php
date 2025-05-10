<?php

namespace App\Livewire\Order;

use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination;

    public ?int $searchByID = null;
    public ?string $searchByClient = null;
    public ?int $searchByOrderStatus = null;

    public array $filters = [];
    public array $columns = ['id', 'user_id', 'status'];
    public bool $filter = false;

    public $selectedPerPage = 5;

    public function updating($property)
    {
        if (in_array($property, ['searchByID', 'searchByClient', 'searchByOrderStatus', 'selectedPerPage'])) {
            $this->resetPage();
        }
    }

    #[Computed()]
    public function orders()
    {
        if ($this->filter and $this->searchByID) {
            $this->filters['id'] = $this->searchByID;
        } else {
            unset($this->filters['id']);
        }

        if ($this->filter and $this->searchByClient) {
            $this->filters['client'] = $this->searchByClient;
        } else {
            unset($this->filters['client']);
        }

        if ($this->filter and $this->searchByOrderStatus) {
            $this->filters['status'] = $this->searchByOrderStatus;
        } else {
            unset($this->filters['status']);
        }

        $data = (new OrderService((new OrderRepository)))->getAll(
            $this->filters,
            $this->selectedPerPage,
            $this->columns
        );

        $this->filter = false;

        if ($data['status'] === 'error') return [];

        return $data['data'];
    }

    public function search()
    {
        $this->filter = true;
    }

    public function render()
    {
        return view('livewire.order.admin-index', [
            'selectOrderStatus' => [
                1 => 'Pendente',
                2 => 'Confirmado',
                3 => 'Enviado',
                4 => 'Completado',
                5 => 'Cancelado',
            ],
            'orders' => $this->orders,
        ])->layout('components.layouts.admin');
    }
}
