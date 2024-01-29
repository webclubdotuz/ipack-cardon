<?php

namespace App\Livewire;

use Livewire\Component;

class Tabs extends Component
{

    public $tabs = [
        "admin" => "user-table",
        "123" => "contact.create-or-update",
    ];

    public $activeTab;

    public function mount()
    {
        foreach ($this->tabs as $key => $value) {
            $this->activeTab = $key;
            break;
        }
    }

    public function changeTab(string $key)
    {
        $this->activeTab = $key;
        $this->render();
    }


    public function render()
    {
        return view('livewire.tabs');
    }
}
