<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Rules\Password;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password as LaravelPassword;

class UserForm extends Form
{
    public $last_name;

    public $first_name;

    public $phone_number;

    public $role;

    public $password;

    public function store()
    {
        // $this->validate();

        $validated = $this->validate([
            'last_name' => 'required|string|max:45|min:1',
            'first_name' => 'required|integer|max:45|min:1',
            'phone_number' => 'required|integer|min:1',
            'role' => 'nullable|string|in:user,administrator',
            'password' => ['required', 'string', 'confirmed', LaravelPassword::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);

        // User::create($this->all());
        // session()->flash('success', 'Bienvenue sur Tontine Burkina');
    }

    public function update(User $user)
    {
        //
    }

    public function delete(User $user)
    {
        //
    }
}
