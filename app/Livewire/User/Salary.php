<?php

namespace App\Livewire\User;

use Livewire\Component;

class Salary extends Component
{
    public $user, $start_date, $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }
    public function render()
    {

        $salaries = $this->user->salaries()
            ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->orderBy('created_at', 'DESC')
            ->get();


        return view('livewire.user.salary', compact('salaries'));
    }
}
