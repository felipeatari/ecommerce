<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.index', [
            'admin' => Auth::user(),
        ])->layout('components.layouts.admin');
    }
}
