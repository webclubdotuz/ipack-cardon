<?php

namespace App\Livewire\Cardon;

use App\Models\Manufacture;
use Livewire\Component;

class ManufactureList extends Component
{

    public $cardon;

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {

        $manufactures = Manufacture::where('cardon_id', $this->cardon->id)
            ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->orderBy('created_at', 'desc')->get();

        return view('livewire.cardon.manufacture-list', compact('manufactures'));
    }
}
