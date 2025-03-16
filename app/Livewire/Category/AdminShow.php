<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminShow extends Component
{
    public Category $category;

    public bool $statusModalDelete = false;

    public function parent(?int $parent)
    {
        if (! $parent) {

            return 'Não';
        }

        $category = Category::find($parent);

        if (! $category) {

            return 'Não';
        }

        return $category->name;
    }

    public function modalDelete()
    {
        $this->statusModalDelete = !$this->statusModalDelete;
    }

    public function destroy()
    {
        DB::beginTransaction();

        try {
            Product::where('category_id', $this->category->id)
                ->update(['category_id' => null]);

            $this->category->delete();

            DB::commit();

            return redirect(route('admin.category.index'));
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.category.admin-show')->layout('components.layouts.admin');
    }
}
