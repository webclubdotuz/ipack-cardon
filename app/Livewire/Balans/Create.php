<?php

namespace App\Livewire\Balans;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{

    use LivewireAlert;
    public $user, $amount, $method, $description;

    protected $listeners = [
        'balansModal' => 'balansModal'
    ];

    public function balansModal($user_id)
    {

        $this->user = User::find($user_id);

        $this->dispatch('openModalBalans');
    }

    public function save()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $this->user->balans()->create([
            'admin_id' => auth()->user()->id,
            'amount' => $this->amount,
            'method' => $this->method ?? 'cash',
            'description' => $this->description
        ]);

        return redirect(url()->previous())->with('success', 'Баланс успешно изменен');
    }

    public function render()
    {
        return view('livewire.balans.create');
    }
}
