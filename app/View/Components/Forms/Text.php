<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected string $col = 'col-12',
        public string $name,
        public string $label,
        public string $value = '',
        public string $type = 'text',
        public string $placeholder = '',
        public bool $required = false,
        public bool $disabled = false,
        public bool $readonly = false,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.text');
    }
}
