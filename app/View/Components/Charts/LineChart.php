<?php

namespace App\View\Components\Charts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LineChart extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = 'Line Chart',
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
        return view('components.charts.line-chart', [
            'title' => $this->title,
            'data' => $this->data,
            'labels' => $this->labels,
        ]);
    }
}
