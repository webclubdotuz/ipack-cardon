<div class="row g-2">
    <div class="col-12">
        <div class="row g-2">
            <div class="col-4">
                <label for="start_date">Начало периода</label>
                <input type="date" class="form-control" id="start_date" wire:model.live="start_date">
            </div>
            <div class="col-4">
                <label for="end_date">Конец периода</label>
                <input type="date" class="form-control" id="end_date" wire:model.live="end_date">
            </div>
            <div class="col-4">
                <label for="type">Тип</label>
                <select class="form-control" id="type" wire:model.live="type">
                    <option value="">Все</option>
                    <option value="roll">Рулон</option>
                    <option value="purchase">Товары</option>
                </select>
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
					<th>Статус платежа</th>
					<th>Дата</th>
					<th></th>
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
                        <td>{!! $transaction->payment_status_html !!}</td>
						<td>{{ df($transaction->created_at, 'd.m.Y H:i') }}</td>
                        <td>
                            @if (hasRoles())
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $transaction->id }})" wire:confirm="Вы уверены?" wire:loading.attr="disabled">
                                    <i class="bx bx-trash"></i>
                                </button>
                            @endif
                        </td>
					</tr>
				@endforeach
			</tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end">Итого:</td>
                    <td>
                        Товары:
                        {{ nf($transactions->map(function($transaction) {
                        return $transaction->purchases->sum('quantity');
                    })->sum(), 2) }} <br>
                        Рулоны:
                        {{ nf($transactions->map(function($transaction) {
                        return $transaction->rolls->sum('weight');
                    })->sum(), 2) }}
                    </td>
                    <td>{{ nf($transactions->sum('total'), 2) }}</td>
                    <td>
                        Долг: {{ nf($transactions->sum('debt'), 2) }} <br>
                        Оплачено: {{ nf($transactions->sum('paid'), 2) }}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
		</table>
	</div>
</div>

@push('js')
	<script>
        Livewire.on('contactCloseModal', () => {
            Livewire.dispatch('refreshContacts');
        });
	</script>
@endpush
