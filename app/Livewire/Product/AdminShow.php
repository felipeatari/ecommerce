<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminShow extends Component
{
    public Product $product;

    public ?string $category = null;
    public ?string $brand = null;

    public bool $statusModalDelete = false;

    public function modalDelete()
    {
        $this->statusModalDelete = !$this->statusModalDelete;
    }

    public function destroy()
    {
        DB::beginTransaction();

        try {
            $this->product->delete();

            DB::commit();

            return redirect(route('admin.product.index'));
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        $this->category = $this->product
            ->category()
            ->first()
            ?->name;

        $this->brand = $this->product
            ->brand()
            ->first()
            ?->name;

        return view('livewire.product.admin-show')
                ->layout('components.layouts.admin');
    }
}
