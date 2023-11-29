<?php

namespace App\Livewire;

use App\Models\Tontine;
use Livewire\Component;
use App\Models\Participant;
use Livewire\Attributes\Js;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\ParticipantForm;

class ShowTontine extends Component
{
    public Tontine $tontine;

    public ParticipantForm $participantForm;

    public string $modalOpen = 'none';

    public string $btnCallAction = '';
    public string $callActionModal = '';

    public string $page = 'tontine-participants';
    public string $pageState = 'add-participants';

    public bool $tontineInfo = true;

    public $searchAddPaticipant = '';

    public $selected = [];

    public string $tontineParticipantModal = "add-participant";

    public $started_at = "";

    public $payments;

    public $participantId = "";

    public function mount()
    {
        $this->showTontine();
        $this->selected = $this->tontine->participants->pluck('id')->toArray();
    }

    public function boot()
    {
        $this->currentPageState();
        $this->payments = $this->tontine->payments;
    }

    private function showTontine()
    {
        $this->dispatch("showTontine", tontineName: $this->tontine->name)->to('Navbar');
    }

    public function render()
    {
        $this->btnCallAction();
        return view('livewire.show-tontine', [
            'allParticipants' => Participant::where('last_name', 'LIKE', "%{$this->searchAddPaticipant}%")
                ->orWhere('first_name', 'LIKE', "%{$this->searchAddPaticipant}%")
                ->orWhere('phone_number', 'LIKE', "%{$this->searchAddPaticipant}%")
                ->orderBy('created_at', 'desc')
                ->get()
        ])
            ->extends('layouts.public')
            ->title($this->tontine->name);
    }

    public function openModal($modal)
    {
        $this->modalOpen = $modal;
    }

    public function storeAndAddParticipant()
    {
        $participant = $this->participantForm->store($this->tontine->id);
        if (!$this->tontine->hasFull(1)) {
            $this->tontine->participants()->attach($participant->id);
        } else {
            session()->flash('success', "Partcipant créer avec succes");
            session()->flash('error', "Tontine pleine imposible d'ajouté ce participant");
        }
        $this->closeModal();
        $this->redirectRoute('tontine.show', $this->tontine->id);
    }

    public function addTontineParticipant()
    {
        $this->tontine->participants()->sync($this->selected);
        $this->closeModal();
        $this->redirectRoute('tontine.show', $this->tontine->id);
    }

    public function closeModal()
    {
        $this->modalOpen = '';
    }

    public function btnCallAction()
    {
        switch ($this->pageState) {
            case 'add-participants':
                $this->btnCallAction = 'Ajouter';
                $this->callActionModal = 'add-participant';
                break;
            case 'get-contributions':
                $this->btnCallAction = 'Valider';
                $this->callActionModal = 'get-contributions';
                break;
            case 'starting-tontine':
                $this->btnCallAction = 'Commencer';
                $this->callActionModal = 'start-tontine';
                break;
            case 'tontine-started':
                $this->btnCallAction = 'Annuler';
                $this->callActionModal = 'tontine-started';
                break;
        }
    }

    private function currentPageState()
    {
        if ($this->tontine->isFull()) {
            if ($this->tontine->isStarted()) {

                if ($this->page == 'tontine-participants') {
                    $this->pageState = 'tontine-started';
                } else {
                    $this->pageState = 'get-contributions';
                }
            } else {
                $this->pageState = 'starting-tontine';
            }
        } else {
            $this->pageState = 'add-participants';
        }
    }

    public function closeTontineInfo()
    {
        $this->tontineInfo = false;
        $this->dispatch("closeTontineInfo")->to('Navbar');
    }

    #[On('openTontineInfo')]
    public function openTontineInfo()
    {
        $this->tontineInfo = true;
    }

    public function addSelected($participantId)
    {
        $this->selected[] = $participantId;
    }

    public function removeSelected($participantId)
    {
        // Trouver la clé de l'élément à supprimer
        $index = array_search($participantId, $this->selected);

        // Supprimer l'élément si trouvé
        if ($index !== false) {
            unset($this->selected[$index]);
        }
    }

    public function addOrCreateAndAdd($option)
    {
        $this->tontineParticipantModal = $option;
    }

    public function changePage($page)
    {
        switch ($page) {
            case 'tontine-participants':
                $this->page = $page;
                break;
            case 'tontine-contributions':
                $this->page = $page;
                break;
        }

        $this->currentPageState();
    }

    public function startTontine()
    {
        $started_at = $this->started_at != "" ? $this->started_at : now();
        if ($this->tontine->startedDateIsValide($started_at)) {
            $this->tontine->update([
                'status' => 'ongoing',
                'started_at' => $started_at
            ]);
            session()->flash("success", 'Tontine Démarrer');
        } else {
            session()->flash("error", 'Date incorecte, veullez entrer une date coherente');
        }
        $this->closeModal();
        $this->redirectRoute('tontine.show', $this->tontine->id);
    }

    public function storePayment($participantId)
    {
        if ($this->tontine->payments()->where('participant_id', $participantId)->count() < $this->tontine->numberOfPeriods()) {
            $this->tontine->payments()->attach($participantId);
        } else {
            session()->flash('error', "Nombre paiment maximal atteint");
            $this->closeModal();
            $this->redirectRoute('tontine.show', $this->tontine->id);
        }
    }

    public function cancelPayment($participantId)
    {
        $payments = $this->tontine->payments()->wherePivot('participant_id', $participantId)->orderByPivot('created_at', "desc")->get();
        if ($payments->count() >= 0) {
            $lastPaymentId = $payments->first()->pivot->id;
            DB::table('tontine_payments')->where('id', '=', $lastPaymentId)->delete();
        } else {
            session()->flash('error', "Nombre paiment minimum atteint");
            $this->closeModal();
            $this->redirectRoute('tontine.show', $this->tontine->id);
        }
    }
}
