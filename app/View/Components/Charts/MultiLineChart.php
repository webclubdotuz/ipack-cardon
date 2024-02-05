<?php

namespace App\View\Components\Charts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiLineChart extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = 'Multi Line Chart',
        public array $series = [],
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
        // dd($this->series);
        return view('components.charts.multi-line-chart', [
            'title' => $this->title,
            'labels' => $this->labels,
        ]);
    }
}
