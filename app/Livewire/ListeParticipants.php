<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\ModalTrait;
use App\Models\Participant;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Livewire\Forms\ParticipantForm;

class ListeParticipants extends Component
{
    use ModalTrait , WithFileUploads;

    public $search = '';

    public ParticipantForm $form;

    public $participantId = '';

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;


    public function render()
    {
        return view('livewire.liste-participants', [
            'participants' => $this->participants()
        ])->extends('layouts.public')
            ->title('Participants');
    }

    public function participants()
    {
        return Participant::where('user_id', auth()->user()->id)
            ->where('last_name', 'LIKE', "%{$this->search}%")
            ->orWhere('first_name', 'LIKE', "%{$this->search}%")
            ->orWhere('phone_number', 'LIKE', "%{$this->search}%")->orderBy('created_at', 'desc')->get();
    }

    public function store()
    {
        $this->form->store();
        $this->redirectRoute('participant.index');
    }

    public function edit(Participant $participant)
    {

        $this->form->id = $participant->id;
        $this->form->last_name = $participant->last_name;
        $this->form->first_name = $participant->first_name;
        $this->form->phone_number = $participant->phone_number;
        $this->form->identity_document_front = $participant->identity_document_front;
        $this->form->identity_document_back = $participant->identity_document_back;

        $this->participantId = $participant->id;

        $this->openModal('edit-participant');
    }

    public function update(Participant $participant)
    {

        $this->form->update($participant);

        $this->closeModal();
        $this->reset('participantId');
        $this->redirectRoute('participant.index');
    }

    public function delete(Participant $participan)
    {
        $this->form->delete($participan);
        $this->closeModal();
        $this->reset('participantId');
        $this->redirectRoute('participant.index');
    }
}
