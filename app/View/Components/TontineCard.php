<?php

namespace App\View\Components;

use Closure;
use App\Models\Tontine;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class TontineCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Tontine $tontine)
    {
        //
    }

    public function status()
    {
        $conf = [];

        switch ($this->tontine->status) {
            case 'creating':
                $conf = [
                    'type' => 'info',
                    'status' => 'Non Démaré'
                ];
                break;
            case 'ongoing':
                $conf = [
                    'type' => 'primary',
                    'status' => 'Démaré'
                ];
                break;
            case 'suspended':
                $conf = [
                    'type' => 'danger',
                    'status' => 'Annuler'
                ];
                break;
            case 'completed':
                $conf = [
                    'type' => 'success',
                    'status' => 'Terminer'
                ];
                break;
        }

        return $conf;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view(
            'components.tontine-card',
            [
                'conf' => $this->status()
            ]
        );
    }
}
