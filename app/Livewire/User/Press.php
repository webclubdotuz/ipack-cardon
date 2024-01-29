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
        $this->presses = PressModel::where('user_id', $this->user->id)
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('livewire.user.press');
    }
}
