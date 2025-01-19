<?php

namespace App\Livewire\Account;

use App\Enums\UserLevel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class Register extends Component
{
    public string $firstName = '';
    public string $lastName = '';
    public ?string $login = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function rules(): array
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'login' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => 'Campo Nome é obrigatório.',
            'lastName.required' => 'Campo Sobrenome é obrigatório.',
            'login.required' => 'Campo E-Mail/WhatsApp é obrigatório.',
            'password.required' => 'Campo Senha é obrigatório.',
            'confirmPassword.required' => 'Campo Confirmar Senha é obrigatório.',
        ];
    }

    public function store(Request $request)
    {
        $this->validate();

        if (
            ! preg_match('/^[\w]+@[\w]+\.[\w]+$/', $this->login) and
            ! preg_match('/^[\d]{10,11}$/', $this->login) and
            ! preg_match('/^\([\d]{2}\)[\d]{4,5}\-[\d]{4}$/', $this->login) and
            ! preg_match('/^\([\d]{2}\)[\d]{1}\.[\d]{4}\-[\d]{4}$/', $this->login)
            ) {
            return $this->addError('login', 'Campo E-Mail/WhatsApp inválido.');
        }

        if ($this->password !== $this->confirmPassword) {
            return $this->addError('login', 'As senhas não são iguais.');
        }

        DB::beginTransaction();

        try {
            $name = $this->firstName . ' ' . $this->lastName;

            $email = null;
            $phone = null;

            if (preg_match('/^[\w]+@[\w]+\.[\w]+$/', $this->login)) {
                $email = $this->login;
            } elseif (
                ! preg_match('/^[\d]{10,11}$/', $this->login) and
                ! preg_match('/^\([\d]{2}\)[\d]{4,5}\-[\d]{4}$/', $this->login) and
                ! preg_match('/^\([\d]{2}\)[\d]{1}\.[\d]{4}\-[\d]{4}$/', $this->login)
                ) {
                $phone = $this->login;
            }

            User::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'email' => $email,
                'phone' => $phone,
                'level' => UserLevel::Costumer,
                'password' => Hash::make($this->password),
            ]);

            DB::commit();

            // return $this->redirect(route('login'));
            if (session()->exists('cart.back_cart')) {
                $this->redirect(route('cart.index'));

                return;
            }

            $this->redirect(route('customer.index'));
        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('db', $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.account.register');
    }
}
