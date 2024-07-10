@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Инвестиции'">
    <a href="{{ route('invensts.create') }}" class="btn btn-sm btn-primary">
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
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Фильтр <i class="bx bx-filter-alt"></i></button>
                        <a href="{{ route('invensts.index') }}" class="btn btn-danger">Сбросить <i class="bx bx-reset"></i></a>
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
                                <th>Описание</th>
                                <th>Создано</th>
                                <th>Сумма</th>
                                <th>Тип оплаты</th>
                                <th>Дата</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invensts as $invenst)
                            <tr>
                                <td>{{ $invenst->id }}</td>
                                <td>{{ $invenst->description }}</td>
                                <td>{{ $invenst->user->fullname }}</td>
                                <td>{{ nf($invenst->amount) }}</td>
                                <td>{{ methods()[$invenst->method] }}</td>
                                <td>{{ df($invenst->date) }}</td>
                                <td>
                                    <form action="{{ route('invensts.destroy', $invenst->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group">
                                            <a href="{{ route('invensts.edit', $invenst->id) }}" class="btn btn-sm btn-primary">
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
                                <th>{{ nf($invensts->sum('amount')) }}</th>
                                <th></th>
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
