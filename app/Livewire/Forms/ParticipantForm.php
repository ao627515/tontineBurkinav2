<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Participant;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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

    public function store()
    {
        $this->validateParticipant();

        $participant = Participant::create($this->getParticipantData());

        $this->storeDocuments($participant);

        session()->flash('success', 'Participant créé avec succès.');

        $this->reset();

        return $participant;
    }

    public function update(Participant $participant)
    {
        $this->validateParticipant();

        $this->updateDocuments($participant);

        $participant->update($this->getParticipantData());

        session()->flash('success', 'Participant modifié avec succès.');

        $this->reset();
    }

    public function delete(Participant $participant)
    {
        $participant->delete();

        session()->flash('success', 'Participant supprimé avec succès.');

        $this->reset();
    }

    private function validateParticipant()
    {
        $this->validate([
            'phone_number' => [
                'required',
                'integer',
                'min:1',
                \Illuminate\Validation\Rule::unique('participants', 'phone_number')
                    ->where('user_id', auth()->user()->id)
                    ->ignore($this->id),
            ],
        ]);
    }

    private function getParticipantData()
    {
        return array_merge(
            $this->all(),
            [
                'user_id' => auth()->user()->id
            ]
        );
    }

    private function storeDocuments(Participant $participant)
    {
        $this->storeDocument($participant, 'identity_document_front');
        $this->storeDocument($participant, 'identity_document_back');
    }

    private function updateDocuments(Participant $participant)
    {
        $this->updateDocument($participant, 'identity_document_front');
        $this->updateDocument($participant, 'identity_document_back');
    }

    private function storeDocument(Participant $participant, string $documentField)
    {
        if ($this->$documentField instanceof TemporaryUploadedFile) {
            $this->$documentField = $this->$documentField->store('identity_document/' . auth()->user()->id . '/' . $participant->id, 'public');
            $this->$documentField = "storage/" . $this->$documentField;
        }
    }

    private function updateDocument(Participant $participant, string $documentField)
    {
        if ($this->$documentField instanceof TemporaryUploadedFile) {
            if ($participant->$documentField) Storage::delete($participant->$documentField);
            $this->$documentField = $this->$documentField->store('identity_document/' . auth()->user()->id . '/' . $participant->id, 'public');
            $this->$documentField = "storage/" . $this->$documentField;
        }
    }
}
