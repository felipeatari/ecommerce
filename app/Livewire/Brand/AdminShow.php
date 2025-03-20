<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use App\Models\Product;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
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
        $data = (new BrandService(new BrandRepository))->delete($this->brand->id);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.brand.index');
    }

    public function render()
    {
        return view('livewire.brand.admin-show')->layout('components.layouts.admin');
    }
}
