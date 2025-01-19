<?php

namespace App\Livewire\Cart;

use App\Models\User;
use App\Models\UserAddress;
use App\Services\ApiViaCepService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Customer extends Component
{
    public ?User $user;
    public ?UserAddress $userAddress;

    // Dados
    public string $name = '';
    public ?string $cpf = null;

    // Contato
    public ?string $email = null;
    public ?string $phone = null;

    // Endereço
    public string $zipCode = '';
    public string $city = '';
    public string $state = '';
    public string $neighborhood = '';
    public string $address = '';
    public ?int $number = null;
    public ?string $complement = null;
    public string $country = 'Brasil';
    public string $countryCode = 'BR';

    public ?string $note = null;
    public array $curtomer = [];
    public array $apiViaCep = [];

    public $zipCodeForm = '';

    public function mount()
    {
        if (! Auth::id()) {
            return $this->redirect(route('login'));
        }

        if (! session()->exists('cart')) {
            return $this->redirect(route('cart.index'));
        }

        if (! session()->exists('cart.product') or ! session()->get('cart.product')) {
            $this->redirect(route('cart.index'));
        }

        $this->user = Auth::user();

        $this->name = $this->user->name;
        $this->cpf = $this->user->cpf;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;

        if ($this->userAddress = $this->user->address) {
            $this->zipCode = $this->userAddress->zip_code;
            $this->city = $this->userAddress->city;
            $this->state = $this->userAddress->state;
            $this->neighborhood = $this->userAddress->neighborhood;
            $this->address = $this->userAddress->address;
            $this->number = $this->userAddress->number;
            $this->complement = $this->userAddress->complement;

            $this->zipCodeForm = $this->userAddress->zip_code;
        }

        if (session()->exists('cart.customer')) {
            $costumer = session()->get('cart.customer');

            $this->name = $costumer['name'];
            $this->cpf = $costumer['cpf'];
            $this->email = $costumer['email'];
            $this->phone = $costumer['phone'];
            $this->zipCode = $costumer['zipCode'];
            $this->city = $costumer['city'];
            $this->state = $costumer['state'];
            $this->neighborhood = $costumer['neighborhood'];
            $this->address = $costumer['address'];
            $this->number = $costumer['number'];
            $this->complement = $costumer['complement'];
            $this->note = $costumer['note'];

            $this->zipCodeForm = $costumer['zipCode'];
        }
    }

    private function validateInputs()
    {
        if (! $this->zipCode) {
            $this->addError('zipCode1', 'O CEP é obrigatório.');

            return true;
        } elseif (! preg_match('/^[\d]{8}$/', $this->zipCode) and ! preg_match('/^[\d]{5}-[\d]{3}$/', $this->zipCode)) {
            $this->addError('zipCode2', 'O CEP é inválido.');

            return true;
        }

        if (! $this->cpf) {
            $this->addError('cpf1', 'O CPF é obrigatório.');

            return true;
        } elseif (! preg_match('/^[\d]{11}$/', $this->cpf) and ! preg_match('/^[\d]{3}.[\d]{3}.[\d]{3}-[\d]{2}$/', $this->cpf)) {
            $this->addError('cpf2', 'O CPF é inválido.');

            return true;
        }
    }

    public function confirm()
    {
        if ($validateInputs = $this->validateInputs()) {
            $this->js('window.scrollTo({top: 0, behavior: "smooth"})');
            return $validateInputs;
        }

        if (session()->exists('cart.customer')) {
            session()->forget('cart.customer');
        }

        if (! UserAddress::query()->where('user_id', Auth::id())->exists()) {
            UserAddress::create([
                'user_id' => Auth::id(),
                'zip_code' => $this->zipCode,
                'city' => $this->city,
                'state' => $this->state,
                'neighborhood' => $this->neighborhood,
                'address' => $this->address,
                'number' => $this->number,
                'complement' => $this->complement,
            ]);
        }
        // else {
        //     $userAddress =Auth::user()->address;
        //     $userAddress->zip_code = $this->zipCode;
        //     $userAddress->city = $this->city;
        //     $userAddress->state = $this->state;
        //     $userAddress->neighborhood = $this->neighborhood;
        //     $userAddress->address = $this->address;
        //     $userAddress->number = $this->number;
        //     $userAddress->complement = $this->complement;
        //     $userAddress->save();
        // }

        $customer = [
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'phone' => $this->phone,
            'zipCode' => $this->zipCode,
            'city' => $this->city,
            'state' => $this->state,
            'neighborhood' => $this->neighborhood,
            'address' => $this->address,
            'number' => $this->number,
            'complement' => $this->complement,
            'country' => $this->country,
            'note' => $this->note,
        ];

        if (! $this->user->cpf) {
            $this->user->cpf = $this->cpf;
            $this->user->save();
        }

        if (! $this->user->email) {
            $this->user->email = $this->email;
            $this->user->save();
        }

        if (! $this->user->phone) {
            $this->user->phone = $this->phone;
            $this->user->save();
        }

        session()->put('cart.customer', $customer);

        return $this->redirect(route('cart.confirm'));
    }

    public function render()
    {
        if ($this->zipCode != $this->zipCodeForm) {
            if (preg_match('/^[\d]{5}-?[\d]{3}$/', $this->zipCode)) {
                $apiViaCep = (new ApiViaCepService)->search($this->zipCode);

                $this->apiViaCep = $apiViaCep;
                $this->zipCode = $apiViaCep['cep'] ?? $this->zipCode;
                $this->city = $apiViaCep['localidade'] ?? '';
                $this->state = $apiViaCep['estado'] ?? '';
                $this->neighborhood = $apiViaCep['bairro'] ?? '';
                $this->address = $apiViaCep['logradouro'] ?? '';
                $this->complement = $apiViaCep['complemento'] ?? null;

                $this->zipCodeForm = $this->zipCode . '+';
            } else {
                $this->city = '';
                $this->state = '';
                $this->neighborhood = '';
                $this->address = '';
                $this->complement = null;
            }
        }

        return view('livewire.cart.customer');
    }
}
