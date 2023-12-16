<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\UserForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;

class Register extends Component
{
    // public UserForm $form;

    public $last_name;

    public $first_name;

    public $phone_number;

    public $password;

    public $password_confirmation;

    public $terms;

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.register');
    }

    public function register()
    {
        $validated = $this->validate([
            'last_name' => 'required|string|max:45|min:1',
            'first_name' => 'required|string|max:45|min:1',
            'phone_number' => 'required|integer|min:1|unique:users',
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'terms' => 'accepted'
        ]);

        // Retirez 'terms' du tableau $validated
        unset($validated['terms']);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        session()->flash('success', 'Bienvenue sur tontine Burkina');

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}
