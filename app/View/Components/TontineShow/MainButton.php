<?php

namespace App\View\Components\TontineShow;

use App\Models\Tontine;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $page, public Tontine $tontine)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tontine-show.main-button');
    }
}
