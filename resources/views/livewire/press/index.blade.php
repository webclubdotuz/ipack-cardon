<div class="row">
    <div class="col-12">
        <div class="row">

        </div>
    </div>
    <div class="col-12 table-responsive">
		<table class="table table-striped table-bordered" id="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Товар</th>
					<th>Пользователь</th>
					<th>Прессовчик</th>
					<th>Кол-во</th>
					<th>Фото</th>
					<th>Дата</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($presses as $press)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $press->product->name }}</td>
						<td>{{ $press->user->fullname }}</td>
                        <td>
                            @foreach ($press->users as $presser)
                            <span class="text-primary">{{ $presser->user->fullname }} | {{ nf($presser->amount,2) }} сум</span><br>
                            @endforeach
                        </td>
						<td>
                            {{ nf($press->quantity, 2) }} кг
						</td>
                        <td>
                            <img src="/storage/{{ $press->image }}" alt="" width="25">
                        </td>
						<td>{{ df($press->created_at, 'd.m.Y H:i') }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="destroy({{ $press->id }})" wire:confirm="Вы уверены?">
                                <i class="bx bx-trash font-size-16 align-middle"></i>
                            </button>
                        </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@push('js')

@endpush
