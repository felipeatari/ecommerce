<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Computed()]
    public function variations()
    {
        return Variation::orderByDesc('id')
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.variation.admin-index', [
            'variations' => $this->variations,
        ])->layout('components.layouts.admin');
    }
}
