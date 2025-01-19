<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Computed()]
    public function products()
    {
        return Product::select(['id', 'name'])
            ->orderByDesc('id')
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.product.admin-index', [
            'products' => $this->products,
        ])->layout('components.layouts.admin');
    }
}
