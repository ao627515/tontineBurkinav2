<?php

namespace App\Livewire;

use App\Models\Tontine;
use Livewire\Component;
use App\Models\Participant;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\TontineForm;
use App\Livewire\Forms\ParticipantForm;

class ShowTontine extends Component
{
    public Tontine $tontine;

    public TontineForm $tontineForm;

    public ParticipantForm $participantForm;

    public string $modalOpen = 'none';

    public string $btnCallAction = '';
    public string $callActionModal = '';

    public string $page = 'tontine-participants';

    public bool $tontineInfo = true;

    public $searchAddPaticipant = '';

    public $selected = [];

    public string $tontineParticipantModal = "add-participant";

    public $started_at;

    public $payments;

    public $participantId = "";

    public string $suspension_reason = '';

    public function mount()
    {
        $this->showTontine();
        $this->selected = $this->tontine->participants->pluck('id')->toArray();
        $this->started_at =  now()->toDateString();
    }

    public function boot()
    {
        $this->payments = $this->tontine->payments;
        if ($this->tontine->isStarted())  $this->dispatch('tontineIsStarted')->to('Navbar');
    }

    private function showTontine()
    {
        $this->dispatch("showTontine", tontineName: $this->tontine->name)->to('Navbar');
    }

    public function render()
    {
        return view(
            'livewire.show-tontine',
            [
                'delay_unity' => ['day' => 'Jour', 'week' => 'Semaine', 'month' => "Mois", 'year' => 'Année'],
                'allParticipants' => $this->allParticipants()
            ]
        )
            ->extends('layouts.public')
            ->title($this->tontine->name);
    }

    public function allParticipants()
    {
        return  Participant::where('user_id', auth()->user()->id)
            ->where('last_name', 'LIKE', "%{$this->searchAddPaticipant}%")
            ->orWhere('first_name', 'LIKE', "%{$this->searchAddPaticipant}%")
            ->orWhere('phone_number', 'LIKE', "%{$this->searchAddPaticipant}%")
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function openModal($modal)
    {
        $this->modalOpen = $modal;
    }

    public function storeAndAddParticipant()
    {
        $participant = $this->participantForm->store($this->tontine->id);
        if (!$this->tontine->hasFull(1)) {
            $this->tontine->participants()->attach($participant->id, ['assigned_rank' => $this->tontine->participationRank()]);
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
        foreach ($this->selected as $key => $id) {

            $this->tontine->participants()->updateExistingPivot($id, ['assigned_rank' => ++$key]);
        }
        $this->closeModal();
        $this->redirectRoute('tontine.show', $this->tontine->id);
    }

    public function closeModal()
    {
        $this->modalOpen = '';
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
    }

    public function startTontine()
    {
        if ($this->tontine->startedDateIsValide($this->started_at)) {
            $this->tontine->update([
                'status' => 'ongoing',
                'started_at' => $this->started_at
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

    public function getContributions(Participant $participant)
    {
        $getContribution = $this->tontine->getContributions();
        $getContribution->attach($participant->id);

        $this->closeModal();

        if ($getContribution->count() == $this->tontine->number_of_members) $this->dispatch('tontine-finish')->self();
        // $this->redirectRoute('tontine.show', $this->tontine->id);
    }

    #[On('tontine-finish')]
    public function tontineFinish()
    {
        $this->tontine->update([
            'status' => 'completed'
        ]);
    }

    public function cancelTontine()
    {
        $this->tontine->update([
            "status" => "suspended",
            "suspension_at" => now(),
            'suspension_reason' => $this->suspension_reason
        ]);
        $this->closeModal();

        $this->reset('suspension_reason');
        session()->flash('success', 'Tontine annuler');
        $this->redirectRoute('tontine.show', $this->tontine->id);
    }

    #[On('editTontine')]
    public function editTontine()
    {
        $this->tontineForm->name = $this->tontine->name;
        $this->tontineForm->profit = $this->tontine->profit;
        $this->tontineForm->delay = $this->tontine->delay;
        $this->tontineForm->delay_unity = $this->tontine->delay_unity;
        $this->tontineForm->amount = $this->tontine->amount;
        $this->tontineForm->number_of_members = $this->tontine->number_of_members;
        $this->tontineForm->description = $this->tontine->description;
        $this->openModal('edit-tontine');
    }

    #[On('deleteTontine')]
    public function deleteTontineEvent()
    {
        $this->openModal('delete-tontine');
    }

    public function updateTontine()
    {
        $this->tontineForm->update($this->tontine);
        $this->redirectRoute('tontine.show', $this->tontine->id);
    }

    public function deleteTontine()
    {
        $this->tontine->delete();
        session()->flash('success', 'Votre tontine a été supprimé avec succès.');

        $this->redirectRoute('home');
    }

    public function relaunch()
    {

        $tontine =  $this->tontine->replicate(['status', 'suspension_at', 'started_at', 'suspension_reason', 'deleted_at']);
        $tontineCount = Tontine::where('name', $tontine->name)->count() + 1;
        $tontine->name = $tontine->name. " {$tontineCount}";
        $tontine->save();
        $participants = $this->tontine->participants()->orderByPivot('assigned_rank')->pluck('participant_id');
        $ranks = range(1, $participants->count());

        foreach ($participants as $index => $participantId) {
            $tontine->participants()->attach($participantId, ['assigned_rank' => $ranks[$index]]);
        }

        session()->flash('success', 'Bienvenue dans votre nouvelle tontine');

        $this->redirectRoute('tontine.show', $tontine->id);
    }
}
