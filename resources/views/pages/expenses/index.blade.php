@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Расходные категории'">
    <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i>
        Добавить
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="" class="row g-2">
                    <div class="col-md-4">
                        <label for="start_date">Начальная дата</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start_date }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">Конечная дата</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end_date }}">
                    </div>
                    <div class="col-md-4">
                        <label for="expense_category_id">Категория</label>
                        <select name="expense_category_id" id="expense_category_id" class="form-control">
                            <option value="">Выберите</option>
                            @foreach (getExpenseCategories() as $expense_category)
                            <option value="{{ $expense_category->id }}" {{ request()->get('expense_category_id') == $expense_category->id ? 'selected' : '' }}>{{ $expense_category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Фильтр <i class="bx bx-filter-alt"></i></button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-danger">Сбросить <i class="bx bx-reset"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-12 table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Категория</th>
                                <th>Описание</th>
                                <th>Создано</th>
                                <th>Сумма</th>
                                <th>Дата</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->id }}</td>
                                <td>{{ $expense->expense_category->name }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->user->fullname }}</td>
                                <td>{{ nf($expense->amount) }}</td>
                                <td>{{ $expense->created_at->format('d.m.Y') }}</td>
                                <td>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group">
                                            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Вы уверены?')">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Итого</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{ nf($expenses->sum('amount')) }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
