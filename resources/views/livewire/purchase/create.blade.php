<div class="row g-1">

	<div class="col-12 mb-3">
		@foreach(getMyProducts() as $product)
			<div class="dropdown d-inline-block m-1">
				<button class="btn btn-sm btn btn-outline-dark" type="button" data-bs-toggle="dropdown">
					<i class="bx bx-cart"></i>
					{{ $product->name }} ({{ nf($product->quantity) }})
				</button>
				<div class="dropdown-menu p-2">
					<input type="number" class="form-control" placeholder="кг" wire:model="qty" step="any" wire:keydown.enter="addCart({{ $product->id }})">
					<button class="btn btn-sm btn btn-primary mt-2" wire:click="addCart({{ $product->id }})">
						Добавить
					</button>
				</div>
			</div>

		@endforeach
	</div>

	<div wire:loading class="col-12">
		<div class="spinner-border text-primary" role="status">
			<span class="visually-hidden">Loading...</span>
		</div>

	</div>


	<div class="col-12 table">
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<th>Товар</th>
					<th>Кол-во</th>
					<th>Цена</th>
					<th>Сумма</th>
					<th>
						<a wire:click="clearCart()" href="#" class="text-danger" wire:confirm="Действительно хотите очистить корзину?">
							<i class="bx bx-trash"></i>
						</a>
					</th>
				</tr>
			</thead>

			<tbody>
                @if($transaction)
                {{-- @dd($transaction); --}}
                    @foreach($transaction->purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->product->name }}</td>
                            <td class="position-relative w-25">
                                {{ $purchase->quantity }} кг
                            </td>
                            <td>
                                {{ nf($purchase->price) }}
                                <a data-bs-toggle="dropdown">
                                    <i class="bx bx-edit text-primary"></i>
                                </a>
                                <div class="dropdown-menu p-2">
                                    @foreach($purchase->product->in_price_lists as $key => $in_price_list)
                                    <span class="badge bg-primary" wire:click="changePrice({{ $purchase->id }}, {{ $in_price_list }})">
                                        {{ nf($in_price_list) }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ nf($purchase->total) }}</td>
                            <td>
                                <div wire:click="removeCart({{ $purchase->id }})">
                                    <i class="bx bx-trash text-danger"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="position-relative">
                                @foreach($purchase->quantity_history as $key => $quantity_history)
                                    <div class="badge bg-primary">
                                        {{ $quantity_history }} <span class="bx bx-x" wire:click="removeQtyHistory({{ $purchase->id }}, {{ $key }})"></span>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                @endif
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">Итого</th>
					<th colspan="2">{{ nf($total) }}</th>
				</tr>
		</table>
	</div>

	<div class="col-md-4">
		<label for="contact_id" class="form-label">Поставщик</label>
		<select wire:model.live="contact_id" class="form-select">
			<option value="">Выберите поставщика</option>
			@foreach(getContacts(['supplier', 'both']) as $contact)
				<option value="{{ $contact->id }}">{{ $contact->fullname }}</option>
			@endforeach
		</select>
		@error('contact_id') <span class="text-danger">{{ $message }}</span> @enderror
	</div>

    @if($contact_id != 1 && $contact_id)
    <div class="col-md-4">
		<label for="amount" class="form-label">Сумма</label>
		<input type="number" class="form-control" wire:model.live.debounce.500ms="amount">
		@error('amount') <span class="text-danger">{{ $message }}</span> @enderror
	</div>
    @else
        <?php $amount = $total; ?>
    @endif

    <div class="col-12">
        <p>
            Заказ на сумму: <b>{{ nf($total) }}</b> <br>
            Оплачено: <b>{{ nf($amount) }}</b> <br>
            Долг: <b class="text-danger">{{ nf($total - $amount) }}</b>
        </p>
    </div>

	<div class="col-md-12" @if(!$contact_id) style="display: none" @endif>
		<button class="btn btn-sm btn-primary" wire:click="save()">
			<i class="bx bx-save"></i>
			Сохранить
		</button>
        <button class="btn btn-sm btn-danger" wire:click="draft()">
			<i class="bx bx-save"></i>
			Черновик
		</button>
	</div>

    <div class="col-12">
        <a data-bs-toggle="dropdown">
            <i class="bx bx-edit text-primary"></i> Черновик ({{ $drafts->count() }})
        </a>
        <div class="dropdown-menu p-2">
            @foreach($drafts as $draft)
                <div class="dropdown-item">
                    <a href="#" wire:click="loadDraft({{ $draft->id }})" wire:confirm="Действительно хотите загрузить черновик?" class="text-primary">
                        {{ $draft->contact->fullname }} ({{ $draft->total }})
                    </a>
                    <a href="#" wire:click="loadDraft({{ $draft->id }})" class="text-success" wire:confirm="Действительно хотите удалить черновик?">
                        <i class="bx bx-check"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
