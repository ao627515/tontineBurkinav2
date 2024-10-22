<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Navbar extends Component
{
    public $page = "";

    public $isShowTontine = false;

    public $tontineInfoIsOpen = true;

    public $tontineIsStarted = false;

    public function render()
    {
        return view('livewire.navbar');
    }

    public function openTontineInfo(){
        if(!$this->tontineInfoIsOpen) {
            $this->dispatch('openTontineInfo')->to('ShowTontine');
            $this->tontineInfoIsOpen = true;
        }
    }

    #[On('showTontine')]
    public function showTontine($tontineName){
        $this->page = $tontineName;
        $this->isShowTontine = true;
    }

    #[On("indexTontine")]
    public function indexTontine($pageName){
        $this->page = $pageName;
    }

    #[On('sendPageName')]
    public function setPageName($pageName){
        $this->page = $pageName;
    }

    #[On('closeTontineInfo')]
    public function openTontineInfo_ui(){
        $this->tontineInfoIsOpen = false;
    }



    public function editTontine() {
        $this->dispatch('editTontine')->to('ShowTontine');
    }

    public function deleteTontine() {
        $this->dispatch('deleteTontine')->to('ShowTontine');
    }

    #[On("tontineIsStarted")]
    public function tontineIsStarted(){
        $this->tontineIsStarted = true;
    }
}
