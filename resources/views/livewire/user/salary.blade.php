<div class="row g-2">
    <div class="col-12">
        <div class="row g-2">
            <div class="col-6">
                <label for="start_date">Начало периода</label>
                <input type="date" class="form-control" id="start_date" wire:model.live="start_date">
            </div>
            <div class="col-6">
                <label for="end_date">Конец периода</label>
                <input type="date" class="form-control" id="end_date" wire:model.live="end_date">
            </div>
        </div>
    </div>
    <div class="col-12 table-responsive">
		<table class="table table-striped table-bordered" id="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Пользователь</th>
					<th>Сумма</th>
                    <th>Тип</th>
                    <th>Описание</th>
					<th>Дата</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($salaries as $salary)
					<tr>
						<td>{{ $loop->iteration }}</td>
                        <td>{{ $salary->admin->fullname }}</td>
                        <td>
                            {{ nf($salary->amount, 2) }} сум
                        </td>
                        <td>
                            {{ $salary->method }}
                        </td>
                        <td>
                            {{ $salary->description }}
                        </td>
						<td>{{ df($salary->created_at, 'd.m.Y H:i') }}</td>
                        <td></td>
					</tr>
				@endforeach
			</tbody>
            <tfoot>
                <tr>
                    <th>Итого</th>
                    <th></th>
                    <th>{{ nf($salaries->sum('amount'), 2) }} кг</th>
                    <th colspan="4"></th>
                </tr>
            </tfoot>
		</table>
	</div>
</div>
@push('js')

@endpush
