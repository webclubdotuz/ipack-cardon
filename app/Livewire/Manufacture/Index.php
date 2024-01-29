<?php

namespace App\Livewire\Manufacture;

use Livewire\Component;
use App\Models\Manufacture;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $start_date, $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    public function delete($id)
    {

        // 24 hours
        $manufacture = Manufacture::find($id);
        if (strtotime($manufacture->created_at) < strtotime('-24 hours')) {
            $this->alert('error', 'Невозможно удалить!');
            return;
        }

        Manufacture::find($id)->delete();
        $this->alert('success', 'Успешно удалено!');
    }

    public function render()
    {

        $manufactures = Manufacture::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->paginate(100);

        return view('livewire.manufacture.index', compact('manufactures'));
    }
}
