<?php

namespace App\View\Components;

use Closure;
use App\Models\Participant;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ParticipantCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Participant $participant, public bool $forTontine = false, public array $selected = [])
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.participant-card');
    }
}
