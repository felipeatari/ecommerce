<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
use App\Repositories\VariationRepository;
use App\Services\VariationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminUpdate extends Component
{
    public Variation $variation;

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

    public function update()
    {
        $this->validate();

        $data = (new VariationService(new VariationRepository))->update($this->variation->id, [
            'type' => $this->type,
            'value' => $this->value,
            'code' => $this->code,
            'extra' => $this->extra,
        ]);

        if ($data['status'] === 'error') {
            return $this->addError('db', $data['message']);
        }

        return redirect()->route('admin.variation.show', ['variation' => $this->variation->id]);
    }

    public function render()
    {
        $this->type = $this->variation->type;
        $this->value = $this->variation->value;
        $this->code = $this->variation->code;
        $this->extra = $this->variation->extra;

        return view('livewire.variation.admin-update')->layout('components.layouts.admin');
    }
}
