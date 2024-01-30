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
					<th>ID</th>
					<th>Поставщик</th>
					<th>Товары</th>
					<th>Сумма</th>
					<th>Дата</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($transactions as $transaction)
					<tr>
						<td>{{ $transaction->id }}</td>
						<td>
                            <a href="{{ route('contacts.show', $transaction->contact->id) }}">{{ $transaction->contact->fullname }}</a>
                        </td>
						<td>
                            @foreach ($transaction->purchases as $purchase)
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{ $purchase->product->name }}
                                    </div>
                                    <div>
                                        <a data-bs-toggle="dropdown" class="text-primary">
                                            {{ nf($purchase->quantity, 2) }} кг
                                        </a>
                                        <div class="dropdown-menu p-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <b>Цена:</b> {{ nf($purchase->price) }} сум <br>
                                                    <b>Кол-во:</b> {{ nf($purchase->quantity, 2) }} кг <br>
                                                    <b>Сумма:</b> {{ nf($purchase->total) }} сум <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($transaction->rolls as $roll)
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{ nf($roll->size) }} cм / {{ nf($roll->paper_weight) }} гр / {{ nf($roll->weight) }} кг
                                    </div>
                                    <div>
                                        <a data-bs-toggle="dropdown" class="text-primary">
                                            {{ nf($roll->total) }} сум
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </td>
						<td>{{ nf($transaction->total, 2) }} {{ $transaction->debt_info }}</td>
						<td>{{ df($transaction->created_at, 'd.m.Y H:i') }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

        {{ $transactions->links() }}
	</div>
</div>

@push('js')
	<script>
        Livewire.on('contactCloseModal', () => {
            Livewire.dispatch('refreshContacts');
        });
	</script>
@endpush
