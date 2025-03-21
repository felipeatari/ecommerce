<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
use App\Repositories\VariationRepository;
use App\Services\VariationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminCreate extends Component
{
    public string $type = '';
    public string $value = '';
    public ?string $code = null;
    public ?string $extra = null;

    protected function rules()
    {
        return [
            'type' => 'required',
            'value' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'type.required' => 'O campo tipo é obrigatório',
            'value.required' => 'O campo valor é obrigatório',
        ];
    }

    public function store()
    {
        $this->validate();

        $data = (new VariationService(new VariationRepository))->create([
            'type' => $this->type,
            'value' => $this->value,
            'code' => $this->code,
            'extra' => $this->extra,
        ]);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.variation.index');
    }

    public function render()
    {
        return view('livewire.variation.admin-create')->layout('components.layouts.admin');
    }
}
