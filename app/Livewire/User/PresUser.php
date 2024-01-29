<?php

namespace App\Livewire\User;

use App\Models\PressUser;
use Livewire\Component;

class PresUser extends Component
{

    public $user, $start_date, $end_date;

    public function mount($user)
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {

        $pres_users = PressUser::where('user_id', $this->user->id)
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->get();

        return view('livewire.user.pres-user', compact('pres_users'));
    }
}
