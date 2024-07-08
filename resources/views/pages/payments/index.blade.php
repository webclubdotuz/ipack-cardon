@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Оплаты и расходы'">

    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" class="row g-2">
                        <div class="col-md-4">
                            <label for="start_date">Начальная дата</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ $start_date }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date">Конечная дата</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ $end_date }}">
                        </div>
                        <div class="col-md-4">
                            <label for="type">Тип</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">Все</option>
                                <option value="sale" {{ $type == 'sale' ? 'selected' : '' }}>Продажи</option>
                                <option value="purchase" {{ $type == 'purchase' ? 'selected' : '' }}>Покупки</option>
                                <option value="roll" {{ $type == 'roll' ? 'selected' : '' }}>Рулон</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="method">Оплата</label>
                            <select name="method" id="method" class="form-control">
                                <option value="">Все</option>
                                @foreach (methods() as $key => $value)
                                    <option value="{{ $key }}" {{ $method == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Фильтр <i class="bx bx-filter-alt"></i></button>
                            <a href="{{ route('payments.index') }}" class="btn btn-danger">Сбросить <i
                                    class="bx bx-reset"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body row g-2">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Сумма</th>
                                    <th>Тип оплаты</th>
                                    <th>Заказ</th>
                                    <th>Клинт/Поставщик</th>
                                    <th>Товары</th>
                                    <th>Дата</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <th>{{ $payment->id }}</th>
                                        <td>{{ nf($payment->amount) }}</td>
                                        <td>{{ methods()[$payment->method] }}</td>
                                        <td>{{ types()[$payment->transaction->type] }}</td>
                                        <td>{{ $payment->transaction->contact->fullname }}</td>
                                        <td></td>
                                        <td>{{ df($payment->created_at) }}</td>
                                        <td>
                                            <form action="{{ route('payments.destroy', $payment->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <div class="btn-group">
                                                    <a href="{{ route('payments.edit', $payment->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>{{ nf($payments->sum('amount')) }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
