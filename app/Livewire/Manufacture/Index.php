<?php

namespace App\Livewire\Manufacture;

use Livewire\Component;
use App\Models\Manufacture;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $start_date, $end_date, $cardon_id;

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    public function delete($id)
    {

        $manufacture = Manufacture::find($id);

        if (strtotime($manufacture->created_at) < strtotime('-24 hours') && !hasRoles()) {
            $this->alert('error', 'Невозможно удалить!');
            return;
        }

        Manufacture::find($id)->delete();

        $this->alert('success', 'Успешно удалено!');
    }

    public function render()
    {

        $manufactures = Manufacture::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->when($this->cardon_id, function ($query) {
            return $query->where('cardon_id', $this->cardon_id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('livewire.manufacture.index', compact('manufactures'));
    }
}
