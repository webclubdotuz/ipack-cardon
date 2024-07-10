@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Касса'">
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="row g-3">
                                <div class="col-12 col-md-3">
                                    <label for="start_date">Дата начала</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ $start_date }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label for="end_date">Дата окончания</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ $end_date }}">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-filter"></i> Фильтр</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>

                                </th>
                                @foreach (methods() as $key=>$value)
                                <th>{{ $value }} </th>
                                @endforeach
                                <th>
                                    Итого
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light">
                                <td>
                                    Сегодня баланс
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    {{ nf(getBalansDateSumma(date('2024-07-01'), $end_date, $key)) }}
                                </td>
                                @endforeach
                                <td>
                                    {{ nf(getBalansDateSumma(date('2024-07-01'), $end_date, null)) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ route('sales.index', ['start_date' => $start_date, 'end_date' => $end_date]) }}" target="_blank">
                                        Продажи
                                    </a>
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    <a href="{{ route('payments.index', ['start_date' => $start_date, 'end_date' => $end_date, 'type' => 'sale', 'method' => $key]) }}" target="_blank">
                                        {{ nf(getPaymentDateSumma($start_date, $end_date, $key, 'sale'), 2) }}
                                    </a>
                                </td>
                                @endforeach
                                <td>
                                    <a href="{{ route('payments.index', ['start_date' => $start_date, 'end_date' => $end_date, 'type' => 'sale']) }}" target="_blank">
                                        {{ nf(getPaymentDateSumma($start_date, $end_date, null, 'sale'), 2) }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ route('purchases.index', ['start_date' => $start_date, 'end_date' => $end_date]) }}" target="_blank">
                                        Покупка
                                    </a>
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    <a href="{{ route('payments.index', ['start_date' => $start_date, 'end_date' => $end_date, 'type' => 'purchase', 'method' => $key]) }}" target="_blank">
                                        {{ nf(getPaymentDateSumma($start_date, $end_date, $key, 'purchase'), 2) }}
                                    </a>
                                </td>
                                @endforeach
                                <td>
                                    <a href="{{ route('payments.index', ['start_date' => $start_date, 'end_date' => $end_date, 'type' => 'purchase']) }}" target="_blank">
                                        {{ nf(getPaymentDateSumma($start_date, $end_date, null, 'purchase'), 2) }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ route('rolls.index', ['start_date' => $start_date, 'end_date' => $end_date]) }}" target="_blank">
                                        Рулон
                                    </a>
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    <a href="{{ route('payments.index', ['start_date' => $start_date, 'end_date' => $end_date, 'type' => 'roll', 'method' => $key]) }}" target="_blank">
                                        {{ nf(getPaymentDateSumma($start_date, $end_date, $key, 'roll'), 2) }}
                                    </a>
                                </td>
                                @endforeach
                                <td>
                                    <a href="{{ route('payments.index', ['start_date' => $start_date, 'end_date' => $end_date, 'type' => 'roll']) }}" target="_blank">
                                        {{ nf(getPaymentDateSumma($start_date, $end_date, null, 'roll'), 2) }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ route('expenses.index', ['start_date' => $start_date, 'end_date' => $end_date]) }}" target="_blank">
                                        Расходы
                                    </a>
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    <a href="{{ route('expenses.index', ['start_date' => $start_date, 'end_date' => $end_date, 'method' => $key]) }}" target="_blank">
                                        {{ nf(getExpensesDateSumma($start_date, $end_date, null, $key), 2) }}
                                    </a>
                                </td>
                                @endforeach
                                <td>
                                    <a href="{{ route('expenses.index', ['start_date' => $start_date, 'end_date' => $end_date]) }}" target="_blank">
                                        {{ nf(getExpensesDateSumma($start_date, $end_date, null, null), 2) }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
