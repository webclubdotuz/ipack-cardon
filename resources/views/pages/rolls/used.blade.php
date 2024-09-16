@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Рулоны (использован)'">
        <a href="{{ route('rolls.index') }}" class="btn btn-sm btn-success">
			<i class="bx bx-list-check"></i>
			Не использован
		</a>
	</x-breadcrumb>

	<div class="row">

		<div class="col">
            <div class="card">
				<div class="card-body">
                    <form action="" method="get" class="row g-2">
                        <div class="col-6">
                            <label for="start_date">Начало периода</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $start_date }}">
                        </div>
                        <div class="col-6">
                            <label for="end_date">Конец периода</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $end_date }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Фильтр</button>
                        </div>
                    </form>
                </div>
            </div>
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
                                        <th>Формат</th>
                                        <th>Плотность (гр)</th>
                                        <th>Вес (кг)</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                        <th>Клей</th>
                                        <th>Дата</th>
                                        <th>Использован</th>
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
                                            <td>{{ nf($roll->price) }}</td>
                                            <td>{{ nf($roll->total) }}</td>
                                            <td>{{ $roll->glue ? 'Есть' : 'Нет' }}</td>
                                            <td>{{ df($roll->created_at) }}</td>
                                            <td>
                                                Дата: {{ df($roll->used_date) }} <br>
                                                Описание: {{ $roll->used_description }} <br>
                                                Пользователь: {{ $roll->used_user->fullname }}


                                            </td>
                                            <td>
                                                <form action="{{ route('rolls.destroy-used', $roll->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены? Рулон не будет использован!')">
                                                        <i class="bx bx-undo"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Итого</th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ nf($rolls->sum('weight')) }} кг</th>
                                        <th></th>
                                        <th>{{ nf($rolls->sum('total')) }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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
                                Формат: <span id="roll-size"></span> <br>
                                Плотность: <span id="roll-paper-weight"></span> <br>
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
                                        <textarea name="description" id="used_description" class="form-control form-control-sm" rows="3" required></textarea>
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
