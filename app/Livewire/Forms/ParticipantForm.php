<?php

namespace App\Livewire\Forms;

use App\Models\Participant;
use Livewire\Form;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Validation;

class ParticipantForm extends Form
{
    public $id = '';

    #[Rule('required|string|max:245')]
    public $last_name;

    #[Rule('required|string|max:245')]
    public $first_name;

    public $phone_number;

    #[Rule('nullable|image')]
    public $identity_document_front;

    #[Rule('nullable|image')]
    public $identity_document_back;

    // public $tontine_id;


    public function store()
    {
        $this->validate([
            'phone_number' => [
                'required',
                'integer',
                Validation\Rule::unique('participants', 'phone_number')->where('user_id', auth()->user()->id),
            ],
        ]);

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

    public function update(Participant $participant)
    {

        $this->validate([
            'phone_number' => [
                'required',
                'integer',
                'min:1',
                Validation\Rule::unique('participants', 'phone_number')
                ->where('user_id', auth()->user()->id)
                ->ignore($this->id),
            ],
        ]);

        $participant->update($this->all());

        session()->flash('success', 'Participant modifé avec succèss.');

        $this->reset();
    }

    public function delete(Participant $participant){
        $participant->delete();

        session()->flash('success', 'Participant supprimé avec succèss.');

        $this->reset();
    }
}
