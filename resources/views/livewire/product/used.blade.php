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
					<th>Сотрудник</th>
                    <th>Кол-во</th>
                    <th>Описание</th>
					<th>Дата</th>
				</tr>
			</thead>
			<tbody>
                @forelse ($product_useds as $product_used)
                    <tr>
                        <td>{{ $product_used->id }}</td>
                        <td>{{ $product_used?->user->fullname }}</td>
                        <td>{{ $product_used->quantity }} {{ $product_used->product->unit }}</td>
                        <td>{{ $product_used->description }}</td>
                        <td>{{ df($product_used->created_at) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Нет данных</td>
                    </tr>
                @endforelse
			</tbody>
            <tfoot>
                <tr>
                    <td>Итого</td>
                    <td></td>
                    <td>{{ nf($product_useds->sum('quantity')) }} {{ $product->unit }}</td>
                    <td></td>
                    <td></td>

                </tr>
            </tfoot>
		</table>
	</div>
</div>

@push('js')

@endpush
