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
                            <tr>
                                <td>
                                    Продажи
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    {{ nf(getPaymentDateSumma($start_date, $end_date, $key, 'sale'), 2) }}
                                </td>
                                @endforeach
                                <td>
                                    {{ nf(getPaymentDateSumma($start_date, $end_date, null, 'sale'), 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Покупка
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    {{ nf(getPaymentDateSumma($start_date, $end_date, $key, 'purchase'), 2) }}
                                </td>
                                @endforeach
                                <td>
                                    {{ nf(getPaymentDateSumma($start_date, $end_date, null, 'purchase'), 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Рулон
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    {{ nf(getPaymentDateSumma($start_date, $end_date, $key, 'roll'), 2) }}
                                </td>
                                @endforeach
                                <td>
                                    {{ nf(getPaymentDateSumma($start_date, $end_date, null, 'roll'), 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Расходы
                                </td>
                                @foreach (methods() as $key=>$value)
                                <td>
                                    {{ nf(getExpensesDateSumma($start_date, $end_date, $expense_category_id=null, $key), 2) }}
                                </td>
                                @endforeach
                                <td>
                                    {{ nf(getExpensesDateSumma($start_date, $end_date, null, null), 2) }}
                                </td>
                            </tr>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
