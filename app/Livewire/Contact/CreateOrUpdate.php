<?php

namespace App\Livewire\Contact;

use Livewire\Component;

class CreateOrUpdate extends Component
{

    public $id;
    public $fullname;
    public $org_name;
    public $phone;
    public $type;
    public $address;
    public $method;

    public $is_type = 'customer';

    protected $listeners = ['edit'=>'edit'];

    protected $rules = [
        'fullname' => 'required|min:3',
        'phone' => 'required|digits:9',
        'type' => 'required',
        'address' => 'nullable',
    ];

    public function __construct($is_type = 'customer')
    {
        $this->is_type = $is_type;
    }

    public function mount($method = 'create', $is_type = 'customer')
    {
        $this->method = $method;
        $this->is_type = $is_type;
    }

    public function create()
    {
        $this->reset();
        $method = 'create';
    }

    public function edit($id)
    {
        $contact = \App\Models\Contact::find($id);

        $this->id = $contact->id;
        $this->fullname = $contact->fullname;
        $this->org_name = $contact->org_name;
        $this->phone = $contact->phone;
        $this->type = $contact->type;
        $this->address = $contact->address;
        $this->method = 'update';

        $this->dispatch('editContact');
    }

    public function StoreOrUpdate()
    {
        $this->validate();

        if ($this->method == 'create') {
            \App\Models\Contact::create([
                'fullname' => $this->fullname,
                'org_name' => $this->org_name,
                'phone' => $this->phone,
                'type' => $this->type,
                'address' => $this->address,
            ]);
        } elseif ($this->method == 'update') {
            $contact = \App\Models\Contact::find($this->id);

            $contact->update([
                'fullname' => $this->fullname,
                'org_name' => $this->org_name,
                'phone' => $this->phone,
                'type' => $this->type,
                'address' => $this->address,
            ]);

        }

        $this->reset();
        $this->dispatch('contactCloseModal');
        $this->dispatch('refreshSaleCreate');
    }

    public function update()
    {
        $this->validate();

        $contact = \App\Models\Contact::find($this->id);

        $contact->update([
            'fullname' => $this->fullname,
            'org_name' => $this->org_name,
            'phone' => $this->phone,
            'type' => $this->type,
            'address' => $this->address,
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact.create-or-update');
    }
}
