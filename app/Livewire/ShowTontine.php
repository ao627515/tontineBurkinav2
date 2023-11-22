<?php

namespace App\Livewire;

use App\Models\Tontine;
use Livewire\Component;

class ShowTontine extends Component
{
    public Tontine $tontine;

    public function render()
    {
        return view('livewire.show-tontine')->extends('layouts.public');;
    }
}
