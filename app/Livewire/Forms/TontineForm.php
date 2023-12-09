<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Tontine;
use Livewire\Attributes\Rule;

class TontineForm extends Form
{

    #[Rule('required|min:1|string')]
    public $name;

    #[Rule('required|min:0|integer')]
    public  $profit = 0;

    #[Rule('required|min:1|integer')]
    public  $delay = 1;

    #[Rule("required|min:3|string|in:day,week,month,year")]
    public  $delay_unity = 'day';

    #[Rule('required|min:1|integer')]
    public  $amount = 0;

    #[Rule('required|min:1|integer')]
    public  $number_of_members = 1;

    #[Rule('nullable|string')]
    public  $description;

    public function store()
    {
        $this->validate();

        Tontine::create(array_merge(
            $this->all(),
            [
                'status' => 'creating',
                // 'user_id' => auth()->user()->id
            ],
        ));

        session()->flash('success', 'Votre tontine a été crée avec succès.');

        $this->reset();
    }

    public function update(Tontine $tontine){
        $this->validate();
        $tontine->update($this->all());
        session()->flash('success', 'Votre tontine a été crée avec succès.');
        $this->reset();
    }
}
