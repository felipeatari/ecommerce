<?php

namespace App\Livewire\Account;

use App\Enums\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public ?string $login = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'login' => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'A senha é obrigatória.',
        ];
    }

    public function access(Request $request)
    {
        $validate = $this->validate();

        if (
            ! preg_match('/^[\w]+@[\w]+\.[\w]+$/', $this->login) and
            ! preg_match('/^[\d]{10,11}$/', $this->login) and
            ! preg_match('/^\([\d]{2}\)[\d]{4,5}\-[\d]{4}$/', $this->login) and
            ! preg_match('/^\([\d]{2}\)[\d]{1}\.[\d]{4}\-[\d]{4}$/', $this->login)
            ) {
            return $this->addError('login', 'Campo E-Mail/WhatsApp inválido.');
        }

        unset($validate['login']);

        if (preg_match('/^[\w]+@[\w]+\.[\w]+$/', $this->login)) {
            $validate['email'] = $this->login;
        } elseif (
            ! preg_match('/^[\d]{10,11}$/', $this->login) and
            ! preg_match('/^\([\d]{2}\)[\d]{4,5}\-[\d]{4}$/', $this->login) and
            ! preg_match('/^\([\d]{2}\)[\d]{1}\.[\d]{4}\-[\d]{4}$/', $this->login)
            ) {
            $validate['phone'] = $this->login;
        }

        if (! Auth::attempt($validate)) {
            $this->addError('userInavalid', 'Usuário não encontrado');

            return;
        }

        $request->session()->regenerate();

        if (Auth::user()?->level?->value === UserLevel::Admin->value) {
            $this->redirect(route('admin'));

            return;
        }

        if (session()->exists('cart.back_cart')) {
            $this->redirect(route('cart.index'));

            return;
        }

        $this->redirect(route('customer.index'));
    }

    public function render()
    {
        return view('livewire.account.login');
    }
}
