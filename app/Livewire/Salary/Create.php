<?php

namespace App\Livewire\Salary;

use App\Models\Salary;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;
    public $user, $amount, $description, $method;

    protected $listeners = [
        'openModalSalary' => 'openModalSalary',
    ];

    function openModalSalary($user_id)
    {

        $this->user = User::find($user_id);

        $this->dispatch('openSalary');
    }

    public function save()
    {
        $this->validate([
            'amount' => 'required',
            'method' => 'required', // 'nullable|exists:users,id
            'description' => 'required',
        ]);

        $salary = new Salary();
        $salary->user_id = $this->user->id;
        $salary->admin_id = auth()->user()->id;
        $salary->amount = $this->amount;
        $salary->method = $this->method;
        $salary->description = $this->description;
        $salary->save();

        $this->alert('success', 'Зарплата успешно добавлена');

        return redirect(url()->previous());
    }

    public function render()
    {
        return view('livewire.salary.create');
    }
}
