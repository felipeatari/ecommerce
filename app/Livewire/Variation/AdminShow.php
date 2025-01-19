<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
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
        DB::beginTransaction();

        try {
            $this->variation->delete();

            DB::commit();

            return redirect(route('admin.variation.index'));
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.variation.admin-show')->layout('components.layouts.admin');
    }
}
