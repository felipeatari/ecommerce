<?php

namespace App\Livewire\Brand;

use App\Repositories\BrandRepository;
use App\Services\BrandService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminCreate extends Component
{
    public string $name = '';
    public ?int $parent = null;

    protected function rules()
    {
        return ['name' => 'required'];
    }

    protected function messages()
    {
        return ['name.required' => 'O campo nome é obrigatório'];
    }

    public function store()
    {
        $this->validate();

        $data = (new BrandService(new BrandRepository))->create([
            'name' => $this->name,
            'slug' => slug($this->name),
        ]);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.brand.index');
    }

    public function render()
    {
        return view('livewire.brand.admin-create')->layout('components.layouts.admin');
    }
}
