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
            <div class="col-6">
                <label for="cardon_id">Продукция</label>
                <select class="form-select" id="cardon_id" wire:model.live="cardon_id">
                    <option value="">Все</option>
                    @foreach (getCardons() as $cardon)
                        <option value="{{ $cardon->id }}">{{ $cardon->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
    <div class="col-12" wire:loading wire:target="start_date, end_date">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="col-12 table-responsive">
		<table class="table table-striped table-bordered" id="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Создатель</th>
					<th>Товары</th>
					<th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
					<th>Описание</th>
					<th>Дата</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($manufactures as $manufacture)
					<tr>
						<td>{{ $manufacture->id }}</td>
						<td>
                            <a href="{{ route('users.show', $manufacture->user->id) }}" class="text-primary">
                                {{ $manufacture->user->fullname }}
                            </a>
                        </td>
						<td>
                            <a href="{{ route('cardons.show', $manufacture->cardon->id) }}" class="text-primary">
                                {{ $manufacture->cardon->name }}
                            </a>
                        </td>
						<td>{{ nf($manufacture->quantity) }} {{ $manufacture->cardon->unit }}</td>
                        <td>{{ nf($manufacture->cardon->price) }} cум</td>
                        <td>{{ nf($manufacture->quantity * $manufacture->cardon->price) }} cум</td>
                        <td>
                            {{ $manufacture->description }}
                        </td>
						<td>{{ df($manufacture->created_at, 'd.m.Y H:i') }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" wire:click="delete({{ $manufacture->id }})" wire:confirm="Вы уверены?">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
					</tr>
				@endforeach
			</tbody>
            <tfoot>
                <tr>
                    <th>Итого</th>
                    <th></th>
                    <th></th>
                    <th>{{ nf($manufactures->sum('quantity')) }}</th>
                    <th></th>
                    <th>
                        {{ nf($manufactures->sum(function($manufacture) {
                            return $manufacture->quantity * $manufacture->cardon->price;
                        })) }} cум
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
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
