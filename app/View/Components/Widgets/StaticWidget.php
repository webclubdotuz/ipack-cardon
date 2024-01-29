<?php

namespace App\View\Components\Widgets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StaticWidget extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = 'Title',
        public string $value = '0',
        public string $icon = 'bx bx-cart',
        public string $color = 'primary',
        public string $route = '#',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.static-widget');
    }
}
