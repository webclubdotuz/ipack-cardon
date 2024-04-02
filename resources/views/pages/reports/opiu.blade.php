@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'ОПиУ и Вал.прибыль'">
	</x-breadcrumb>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="row">
                                <div class="col-12 col-md-3">
                                    <label for="year">Год</label>
                                    <div class="input-group">
                                        <select name="selected_year" id="selected_year" class="form-select">
                                            @foreach ($transactionYears as $transactionYear)
                                                <option value="{{ $transactionYear->year }}" @if ($transactionYear->year == $selected_year) selected @endif>
                                                    {{ $transactionYear->year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-filter"></i> Фильтр</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>

        <div class="col-12">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-sm table-bordered">
                                <h3>Валовой прибыль</h3>
                                <thead>
                                    <tr>
                                        <th>Период</th>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <th>{{ monthName($transactionMonth->month) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Общий Сумма Продажи</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsTotal($selected_year, $transactionMonth->month, 'sale')) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Общий Сумма Покупки</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsTotal($selected_year, $transactionMonth->month, 'purchase')) }}</td>
                                        @endforeach
                                    </tr>
                                    @foreach (getExpenseCategories() as $expenseCategory)
                                        <tr>
                                            <td>{{ $expenseCategory->name }}</td>
                                            @foreach ($transactionMonths as $transactionMonth)
                                                <td>{{ nf(getExpensesYM($selected_year, $transactionMonth->month, $expenseCategory->id)) }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Валовой прибыль</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsTotal($selected_year, $transactionMonth->month, 'sale') - getTransactionsTotal($selected_year, $transactionMonth->month, 'purchase') - getExpensesYM($selected_year, $transactionMonth->month, null)) }}</td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>

        <div class="col-12">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-sm table-bordered">
                                <h3>ОПиУ</h3>
                                <thead>
                                    <tr>
                                        <th>Период</th>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <th>{{ monthName($transactionMonth->month) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Общий Сумма Продажи</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsTotal($selected_year, $transactionMonth->month, 'sale')) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Общий Сумма Покупки</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsTotal($selected_year, $transactionMonth->month, 'purchase')) }}</td>
                                        @endforeach
                                    </tr>
                                    @foreach (getExpenseCategories() as $expenseCategory)
                                        <tr>
                                            <td>{{ $expenseCategory->name }}</td>
                                            @foreach ($transactionMonths as $transactionMonth)
                                            {{-- @dd($expenseCategory->id) --}}
                                                <td>{{ nf(getExpensesYM($selected_year, $transactionMonth->month, $expenseCategory->id)) }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td>Задолженность клиента</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsDebt($selected_year, $transactionMonth->month, 'sale')) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Задолженность поставщика</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsDebt($selected_year, $transactionMonth->month, 'purchase')) }}</td>
                                        @endforeach
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Валовой прибыль</td>
                                        @foreach ($transactionMonths as $transactionMonth)
                                            <td>{{ nf(getTransactionsTotal($selected_year, $transactionMonth->month, 'sale') - getTransactionsTotal($selected_year, $transactionMonth->month, 'purchase') - getExpensesYM($selected_year, $transactionMonth->month, null) + getTransactionsDebt($selected_year, $transactionMonth->month, 'sale') - getTransactionsDebt($selected_year, $transactionMonth->month, 'purchase')) }}</td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
@endsection
