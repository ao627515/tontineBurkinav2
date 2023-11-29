<?php

namespace App\View\Components;

use Closure;
use App\Models\Participant;
use App\Models\Tontine;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ParticipantCard extends Component
{
    public $badgeType;
    public $status;

    /**
     * Create a new component instance.
     */
    public function __construct(public Participant $participant, public ?Tontine $tontine, public bool $forTontine = false, public ?array $selected = [])
    {
        if ($tontine) {
            $statusAndBadgeType = $participant->getParticipantStatusAndBadgeType($tontine);
            $this->status = $statusAndBadgeType['status'];
            $this->badgeType = $statusAndBadgeType['badgeType'];
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.participant-card');
    }
}
