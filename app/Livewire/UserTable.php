<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => 'table-bordered table-hover'
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("ФИО", "fullname")
                ->sortable(),
            Column::make("Логин", "username")
                ->sortable(),
            Column::make("Тел", "phone")
                ->sortable(),
            Column::make("Роль", "id")
                ->format(fn($value, $row, $column) => $row->roles->map->name->implode(', '))
                ->html(),
            // Column::make("Попупки баланс", "id")
            //     ->format(fn($value, $row, $column) => nf(User::find($value)->balance) . ' сум')
            //     ->html(),
            // Column::make("Зарплата баланс", "id")
            //     ->format(fn($value, $row, $column) => nf(User::find($value)->salary_balance) . ' сум')
            //     ->html(),
            Column::make("Действия", "id")
                ->format(fn($value, $row, $column) => view('pages.users.actions', compact('value'))),
        ];
    }
}
