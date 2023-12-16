<?php

namespace App\Livewire\Forms;

use App\Models\Participant;
use Livewire\Form;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;

class ParticipantForm extends Form
{
    #[Rule('required|string|max:245')]
    public $last_name;

    #[Rule('required|string|max:245')]
    public $first_name;

    #[Rule('required|integer')]
    public $phone_number;

    #[Rule('nullable|image')]
    public $identity_document_front;

    #[Rule('nullable|image')]
    public $identity_document_back;
    // public $tontine_id;

    public function store($tontine_id)
    {
        $this->validate();

        $participant = Participant::create(array_merge(
            $this->all(),
            [
                'user_id' => auth()->user()->id
            ],
        ));

        session()->flash('success', 'Participant creer avec succèss.');

        $this->reset();

        return $participant;
    }
}
