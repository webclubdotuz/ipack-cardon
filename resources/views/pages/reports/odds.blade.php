@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'ОДДС'">
	</x-breadcrumb>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="row">
                                <div class="col-12 col-md-3">
                                    <label for="selected_year">Год</label>
                                    <div class="input-group">
                                        <select class="form-select" id="selected_year" name="selected_year">
                                            @for($i = 2024; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}" {{ $selected_year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
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
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Январь</th>
                                        <th>Февраль</th>
                                        <th>Март</th>
                                        <th>Апрель</th>
                                        <th>Май</th>
                                        <th>Июнь</th>
                                        <th>Июль</th>
                                        <th>Август</th>
                                        <th>Сентябрь</th>
                                        <th>Октябрь</th>
                                        <th>Ноябрь</th>
                                        <th>Декабрь</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-success">
                                        <td><b>Поступления</b></td>
                                        @for($i = 1; $i <= 12; $i++)
                                            <td>{{ nf(getPaymentSumma($selected_year, $i, null, 'sale')) }}</td>
                                        @endfor
                                    </tr>

                                    <tr class="bg-warning">
                                        <td><b>Выплаты</b></td>
                                        @for($i = 1; $i <= 12; $i++)
                                            <td>{{ nf(getExpensesYM($selected_year, $i, null)) }}</td>
                                        @endfor
                                    </tr>

                                    <tr>
                                        <td><b>Поставщики</b></td>
                                        @for($i = 1; $i <= 12; $i++)
                                            <td>{{ nf(getPaymentSumma($selected_year, $i, null, 'purchase')) }}</td>
                                        @endfor
                                    </tr>

                                    @foreach (getExpenseCategories() as $category)
                                        <tr>
                                            <td><b>{{ $category->name }}</b></td>
                                            @for($i = 1; $i <= 12; $i++)
                                                <td>{{ nf(getExpensesYM($selected_year, $i, $category->id)) }}</td>
                                            @endfor
                                        </tr>
                                    @endforeach

                                    <tr class="bg-info">
                                        <td><b>Остаток</b></td>
                                        @for($i = 1; $i <= 12; $i++)
                                            <?php $summa = getPaymentSumma($selected_year, $i, null, 'sale') - (getExpensesYM($selected_year, $i, null) + getBalansYM($selected_year, $i, null)) ?>
                                            <td class="{{ $summa < 0 ? 'text-danger' : '' }}">{{ nf($summa) }}</td>
                                        @endfor
                                    </tr>

                                    @foreach (methods() as $key => $method)
                                        <tr>
                                            <td><b>{{ $method }}</b></td>
                                            @for($i = 1; $i <= 12; $i++)
                                                <?php $summa = getPaymentSumma($selected_year, $i, $key, 'sale') - getExpensesYM($selected_year, $i, null, $key) - getBalansYM($selected_year, $i, $key) ?>
                                                <td class="{{ $summa < 0 ? 'text-danger' : '' }}">{{ nf($summa) }}</td>
                                            @endfor
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
@endsection
