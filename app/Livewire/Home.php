<?php

namespace App\Livewire;

use App\Models\Tontine;
use Livewire\Component;
use Livewire\Attributes\Url;
use App\Livewire\Forms\TontineForm;
use Livewire\Attributes\Title;

class Home extends Component
{
    public bool $modalIsOpen = false;

    public TontineForm $tontineForm;

    #[Url]
    public $search = '';

    public $title = "Mes tontines";

    public function mount(){
        $this->dispatch('sendPageName', pageName: $this->title)->to('Navbar');
    }

    #[Title('Mes tontines')]
    public function render()
    {
        $delay_unity = ['day' => 'Jour', 'week' => 'Semaine', 'month' => "Mois", 'year' => 'Année'];
        return view('livewire.home',
        [
            'delay_unity' => $delay_unity,
            'tontines' => Tontine::where('name', 'LIKE', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->get()
        ])->extends('layouts.public');
    }


    public function openModal(){
        $this->modalIsOpen = true;
    }

    public function closeModal(){
        $this->reset();
        $this->modalIsOpen = false;
    }

    public function storeTontine(){

        $this->tontineForm->store();

        $this->closeModal();

        $this->redirect('/');
    }

}
