<?php

namespace App\View\Components\Charts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pie extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = 'Pie Chart',
        public array $data = ['98', '100', '102', '105'],
        public array $labels = ['Nokisbaev', 'Nurzhanov', 'Kenzhebayev', 'Kenzhebayev']
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.charts.pie');
    }
}
