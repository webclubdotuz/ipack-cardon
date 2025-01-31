<?php

namespace App\Livewire\Payment;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class PaymentList extends DataTableComponent
{
    protected $model = Payment::class;

    public $contact;

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setTableAttributes([
            'class' => 'table-bordered table-hover',
        ])->setSortDesc('created_at');
    }

    public function builder(): Builder
    {
        return Payment::query()
            ->when($this->contact, function ($query) {
                return $query->where('payments.contact_id', $this->contact->id);
            });
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Контакт", "contact.fullname")
                ->sortable(),
                //     <button type="button" class="m-2 btn-block btn btn-success btn-sm"
            //     wire:click="$dispatch('openModalTransactionShow', { transaction_id: {{ $transaction->id }} })">
            //     <i class="bx bx-show"></i>[Показать]
            // </button>
            Column::make("Transaction id", "transaction_id")
                ->sortable()
                ->format(fn($value) => "<button type='button' class='m-2 btn-block btn btn-success btn-sm' wire:click=\"\$dispatch('openModalTransactionShow', { transaction_id: $value })\"><i class='bx bx-show'></i>$value</button>")->html(),
            Column::make("Method", "method")
                ->sortable()
                ->format(fn($value) => methods()[$value]),
            Column::make("Amount", "amount")
                ->sortable()
                ->format(fn($value) => nf($value))
                ->footer(fn($model) => nf($model->sum('amount'))),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Type", "transaction.type")
                ->sortable()
                ->format(fn($value) => types()[$value]),
            Column::make("Дата", "created_at")
                ->sortable()
                ->format(fn($value) => df($value)),
        ];
    }

    public function filters(): array
    {
        return [
            DateFilter::make('Начало')
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('payments.created_at', '>=', $value);
                }),
            DateFilter::make('Конец')
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('payments.created_at', '<=', $value);
                }),
            SelectFilter::make('Тип')
                ->options([''=>'Все'] + types())
                ->filter(function (Builder $builder, string $value) {
                    $builder->whereHas('transaction', function ($query) use ($value) {
                        $query->where('type', $value);
                    });
                })
        ];
    }
}
