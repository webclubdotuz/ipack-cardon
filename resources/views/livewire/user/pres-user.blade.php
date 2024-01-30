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
					<th>Товар</th>
					<th>Кол-во</th>
					<th>Сумма</th>
					<th>Фото</th>
					<th>Дата</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($pres_users as $pres_user)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $pres_user->press->product->name }}</td>
						<td>
                            {{ nf($pres_user->press->quantity, 2) }} кг
						</td>
                        <td>
                            {{ nf($pres_user->amount, 2) }} сум
                        </td>
                        <td>
                            <img src="/storage/{{ $pres_user->press->image }}" alt="" width="25">
                        </td>
						<td>{{ df($pres_user->press->created_at, 'd.m.Y H:i') }}</td>
					</tr>
				@endforeach
			</tbody>
            <tfoot>
                <tr>
                    <th>Итого</th>
                    <th></th>
                    <th>{{ nf($pres_users->sum('press.quantity'), 2) }} кг</th>
                    <th>{{ nf($pres_users->sum('amount'), 2) }} сум</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
		</table>
	</div>
</div>
@push('js')

@endpush
