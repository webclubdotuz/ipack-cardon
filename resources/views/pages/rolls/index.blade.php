@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Рулоны (не использован)'">
        <a href="{{ route('rolls.used') }}" class="btn btn-sm btn-success">
			<i class="bx bx-list-check"></i>
			Использовать
		</a>
	</x-breadcrumb>

	<div class="row">

		<div class="col">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-alert />
                        </div>
                        <div class="col-12 table-responsive">
                            <table class="table table-striped table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Размер</th>
                                        <th>Мощность (гр)</th>
                                        <th>Вес (кг)</th>
                                        <th>Клей</th>
                                        <th>Дата</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rolls as $roll)
                                        <tr>
                                            <td>{{ $roll->id }}</td>
                                            <td>{{ nf($roll->size) }} cм</td>
                                            <td>{{ nf($roll->paper_weight) }} гр</td>
                                            <td>{{ nf($roll->weight) }} кг</td>
                                            <td>{{ $roll->glue ? 'Есть' : 'Нет' }}</td>
                                            <td>{{ $roll->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="initRoll({{ $roll->id }}, {{ $roll->size }}, {{ $roll->paper_weight }}, {{ $roll->weight }}, {{ $roll->glue }})">
                                                    <i class="bx bx-check"></i>
                                                    Использовать
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

    <!-- Modal -->
    <div class="modal fade" id="usedModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Использованные рулоны</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <p>
                                ID рулона: <span id="roll-id"></span> <br>
                                Размер: <span id="roll-size"></span> <br>
                                Мощность: <span id="roll-paper-weight"></span> <br>
                                Вес: <span id="roll-weight"></span> <br>
                                Клей: <span id="roll-glue"></span> <br>
                            </p>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('rolls.used') }}" method="post">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="used_description">Описание</label>
                                        <textarea name="used_description" id="used_description" class="form-control form-control-sm" rows="3" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="used_date">Дата</label>
                                        <input type="date" name="used_date" id="used_date" class="form-control form-control-sm" required value="{{ date('Y-m-d') }}">
                                    </div>
                                    <input type="hidden" name="roll_id" id="roll_id" required>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Отмена</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>

    function initRoll(id, size, paperWeight, weight, glue) {
        $('#roll-id').text(id);
        $('#roll-size').text(size);
        $('#roll-paper-weight').text(paperWeight);
        $('#roll-weight').text(weight);
        $('#roll-glue').text(glue);
        $('#roll_id').val(id);

        $('#usedModal').modal('show');
    }

</script>
@endpush
