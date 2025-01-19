<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
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

        DB::beginTransaction();

        try {
            Variation::create([
                'type' => $this->type,
                'value' => $this->value,
                'code' => $this->code,
                'extra' => $this->extra,
            ]);

            DB::commit();

            return $this->js('alert("Variação criada com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.variation.admin-create')->layout('components.layouts.admin');
    }
}
