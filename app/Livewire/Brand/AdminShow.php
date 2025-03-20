<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminShow extends Component
{
    public Brand $brand;

    public bool $statusModalDelete = false;

    public function modalDelete()
    {
        $this->statusModalDelete = !$this->statusModalDelete;
    }

    public function destroy()
    {
        DB::beginTransaction();

        try {
            // Product::where('brand_id', $this->brand->id)
            //     ->update(['brand_id' => null]);

            $this->brand->delete();

            DB::commit();

            return redirect(route('admin.brand.index'));
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.brand.admin-show')->layout('components.layouts.admin');
    }
}
