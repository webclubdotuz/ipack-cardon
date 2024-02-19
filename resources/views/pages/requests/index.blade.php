@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Заявки'">
    <a href="{{ route('requests.create') }}" class="btn btn-sm btn-primary">
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
                        <label for="status" class="form-label">Статус</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Выберите</option>
                            <option value="pending">В ожидании</option>
                            <option value="approved">Одобрено</option>
                            <option value="rejected">Отклонено</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Фильтр <i class="bx bx-filter-alt"></i></button>
                        <a href="/" class="btn btn-danger">Сбросить <i class="bx bx-reset"></i></a>
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
                                <th>Клиент</th>
                                <th>Кардон</th>
                                <th>Количество</th>
                                <th>Описание</th>
                                <th>Срок</th>
                                <th>Статус</th>
                                <th>Дата</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->contact->fullname }}</td>
                                <td>{{ $request->cardon->name }}</td>
                                <td>{{ $request->quantity }}</td>
                                <td>{{ $request->description }}</td>
                                <td>{{ df($request->deadline) }}</td>
                                <td>{!! $request->status_html !!}</td>
                                <td>{{ df($request->created_at) }}</td>
                                <td>
                                    <form action="{{ route('requests.destroy', $request->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group">
                                            <a href="{{ route('requests.edit', $request->id) }}" class="btn btn-sm btn-primary">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
