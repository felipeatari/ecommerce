<?php

namespace App\Livewire\Sku;

use App\Models\Sku;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AdminIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Computed()]
    public function skus()
    {
        return Sku::with(['product' => function($query){
                $query->select('id', 'name');
            }])
            ->with(['variation1' => function($query){
                $query->select('id', 'value');
            }])
            ->with(['variation2' => function($query){
                $query->select('id', 'value');
            }])
            ->select(['id', 'product_id', 'variation_id_1', 'variation_id_2' , 'price'])
            ->orderByDesc('id')
            ->paginate(5);
    }

    public function render()
    {
        $this->skus->each(function(Sku $sku) {
            $sku->variation = $sku->variation1->value;
            $sku->variation .= ' - ';
            $sku->variation .= $sku->variation2->value;
        });

        return view('livewire.sku.admin-index', [
            'skus' => $this->skus,
        ])->layout('components.layouts.admin');
    }
}
