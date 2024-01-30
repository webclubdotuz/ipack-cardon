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
					<th>Создатель</th>
                    <th>Кол-во</th>
                    <th>Описание</th>
					<th>Дата</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($manufactures as $manufacture)
                    <tr>
                        <td>{{ $manufacture->id }}</td>
                        <td>{{ $manufacture->user->fullname }}</td>
                        <td>{{ nf($manufacture->quantity) }}</td>
                        <td>{{ $manufacture->description }}</td>
                        <td>{{ df($manufacture->created_at) }}</td>
                    </tr>
                @endforeach
			</tbody>
		</table>
	</div>
</div>

@push('js')

@endpush
