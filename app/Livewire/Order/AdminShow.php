<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminShow extends Component
{
    public Order $order;

    public function render()
    {
        return view('livewire.order.admin-show')
                ->layout('components.layouts.admin');
    }
}
