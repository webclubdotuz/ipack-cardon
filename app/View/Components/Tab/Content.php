<?php

namespace App\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component
{
    /**
     * Create a new component instance.
     */

    public $activeShow;
    public function __construct(
        public $id = 'home',
        public $active = false,
    )
    {
        $this->activeShow = $this->active ? 'show active' : '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab.content');
    }
}
