<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
use App\Repositories\VariationRepository;
use App\Services\VariationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminShow extends Component
{
    public Variation $variation;

    public bool $statusModalDelete = false;

    public function modalDelete()
    {
        $this->statusModalDelete = !$this->statusModalDelete;
    }

    public function destroy()
    {
        $data = (new VariationService(new VariationRepository))->remove($this->variation->id);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.variation.index');
    }

    public function render()
    {
        return view('livewire.variation.admin-show')->layout('components.layouts.admin');
    }
}
