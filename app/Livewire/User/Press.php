<?php

namespace App\Livewire\User;

use Livewire\Component;

use App\Models\Press as PressModel;

class Press extends Component
{

    public $user, $presses;

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {
        $this->presses = [];

        return view('livewire.user.press');
    }
}
