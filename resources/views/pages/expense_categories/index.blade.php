@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Расходные категории'">
    <a href="{{ route('expense-categories.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i>
        Добавить
    </a>
</x-breadcrumb>

<div class="row">

    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expense_categories as $expense_category)
                        <tr>
                            <td>{{ $expense_category->id }}</td>
                            <td>{{ $expense_category->name }}</td>
                            <td>
                                <form action="{{ route('expense-categories.destroy', $expense_category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group">
                                        <a href="{{ route('expense-categories.edit', $expense_category->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        @if ($expense_category->expenses->count() == 0)
                                        <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Вы уверены?')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
