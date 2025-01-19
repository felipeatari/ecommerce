<?php

namespace App\Livewire\Variation;

use App\Models\Variation;
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

        DB::beginTransaction();

        try {
            $this->variation->type = $this->type;
            $this->variation->value = $this->value;
            $this->variation->code = $this->code;
            $this->variation->extra = $this->extra;
            $this->variation->save();

            DB::commit();

            return $this->js('alert("Variação editada com sucesso.")');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
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
