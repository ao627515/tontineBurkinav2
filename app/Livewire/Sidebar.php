<?php

namespace App\Livewire;

use App\Traits\LogOut;
use Livewire\Component;

class Sidebar extends Component
{
    use LogOut;

    public function render()
    {
        return view('livewire.sidebar');
    }
}
