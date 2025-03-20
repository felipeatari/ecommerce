<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminUpdate extends Component
{
    public Brand $brand;
    public string $name = '';

    protected function rules()
    {
        return ['name' => 'required'];
    }

    protected function messages()
    {
        return ['name.required' => 'O campo nome é obrigatório'];
    }


    public function update()
    {
        $this->validate();

        $data = (new BrandService(new BrandRepository))->update($this->brand->id, [
            'name' => $this->name,
            'slug' => slug($this->name)
        ]);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.brand.show', ['brand' => $this->brand->id]);
    }

    public function render()
    {
        $this->name = $this->brand->name;
        $this->parent = $this->brand->parent;

        return view('livewire.brand.admin-update')->layout('components.layouts.admin');
    }
}
