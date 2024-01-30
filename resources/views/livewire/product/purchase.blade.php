<div class="row g-2">
    <div class="col-12" wire:loading>
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
    </div>
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
					<th>ID</th>
					<th>Поставщик</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
					<th>Сумма</th>
					<th>Дата</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->transaction->contact->fullname }}</td>
                        <td>{{ nf($purchase->quantity) }}</td>
                        <td>{{ nf($purchase->price) }}</td>
                        <td>{{ nf($purchase->total) }}</td>
                        <td>{{ df($purchase->created_at) }}</td>
                    </tr>
                @endforeach
			</tbody>
		</table>
	</div>
</div>

@push('js')

@endpush
