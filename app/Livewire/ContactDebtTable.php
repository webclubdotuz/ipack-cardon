<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Contact;

class ContactDebtTable extends DataTableComponent
{
    protected $model = Contact::class;

    public $type = "customer";

    protected $listeners = ['refreshContacts' => '$refresh'];

    public function builder() : Builder
    {
        if ($this->type == "customer") {
            return Contact::whereIn('type', ['customer', 'both'])->whereHas('transactions', function ($query) {
                $query->where('type', 'sale')->where('payment_status', 'debt');
            });
        } elseif ($this->type == "supplier") {
            return Contact::whereIn('type', ['supplier', 'both'])->whereHas('transactions', function ($query) {
                $query->where('type', 'purchase')->where('payment_status', 'debt');
            });
        }
    }

    public function __construct($type = "customer")
    {
        $this->type = $type;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setTableAttributes(['class' => 'table-bordered table-hover']);
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->sortable(),
            Column::make("ФИО", "fullname")->sortable()
            ->format(fn($value, $row, $column) => "<a href='".route('contacts.show', $row->id)."'>$value</a>")
            ->html()
            ->searchable(),
            Column::make("Тел", "phone")->sortable()->searchable(),
            Column::make("Баланс", "id")->format(fn($value, $row, $column) => nf($this->balance($value)))->sortable(),

            Column::make("Дата", "created_at")->format(fn($value, $row, $column) => df($value, 'd.m.Y H:i'))->sortable(),
            Column::make("Действия", "id")->format(fn($value, $row, $column) => view('pages.contacts.actions', compact('value'))),
        ];
    }


    protected function balance($id)
    {
        $contact = Contact::find($id);
        if ($this->type == "customer") {
            return $contact->customer_balance;
        } elseif ($this->type == "supplier") {
            return $contact->supplier_balance;
        }
    }
}
