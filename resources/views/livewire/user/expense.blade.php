<div class="row g-2">
    <div class="col-12">
        <div class="row g-2">
            <div class="col-6">
                <label for="start_date">Начало периода</label>
                <input type="date" class="form-control" id="start_date" wire:model="start_date">
            </div>
            <div class="col-6">
                <label for="end_date">Конец периода</label>
                <input type="date" class="form-control" id="end_date" wire:model="end_date">
            </div>
        </div>
    </div>
    <div class="col-12 table-responsive">
		<table class="table table-striped table-bordered" id="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Создатель</th>
					<th>Сумма</th>
					<th>Дата</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($expenses as $expense)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $expense->user->fullname }}</td>
						<td>
                            {{ nf($expense->amount, 2) }} сум
						</td>
						<td>{{ df($expense->created_at, 'd.m.Y H:i') }}</td>
					</tr>
				@endforeach
			</tbody>
            <tfoot>
                <tr>
                    <th>Итого</th>
                    <th></th>
                    <th>{{ nf($expenses->sum('amount'), 2) }} сум</th>
                    <th></th>
                </tr>
            </tfoot>
		</table>
	</div>
</div>
@push('js')

@endpush
