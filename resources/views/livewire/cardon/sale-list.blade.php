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
					<th>Продавец</th>
					<th>Клиент</th>
                    <th>Описание</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Сумма</th>
					<th>Дата</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->user->fullname }}</td>
                        <td>{{ $sale->transaction->contact->fullname }}</td>
                        <td>{{ $sale->description }}</td>
                        <td>{{ nf($sale->quantity) }} {{ $sale->cardon->unit }}</td>
                        <td>{{ nf($sale->price) }}</td>
                        <td>{{ nf($sale->total) }}</td>
                        <td>{{ df($sale->created_at) }}</td>
                    </tr>
                @endforeach
			</tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Итого:</th>
                    <th>{{ nf($sales->sum('quantity')) }}</th>
                    <th></th>
                    <th>{{ nf($sales->sum('total')) }}</th>
                    <th></th>
                </tr>
            </tfoot>
		</table>
	</div>
</div>

@push('js')

@endpush
