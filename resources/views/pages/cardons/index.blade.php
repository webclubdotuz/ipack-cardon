@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Кардоны'">
        <a href="{{ route('cardons.create') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-plus"></i>
            Добавить
        </a>
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Длина</th>
                                        <th>Ширина</th>
                                        <th>Высота</th>
                                        <th>Слой</th>
                                        <th>Зарплата</th>
                                        <th>Цена</th>
                                        <th>Количество</th>
                                        <th>Сумма</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; $this_total = 0; ?>
                                    @foreach ($cardons as $cardon)
                                    <tr>
                                        <td>{{ $cardon->name }}</td>
                                        <td>{{ $cardon->length }}</td>
                                        <td>{{ $cardon->width }}</td>
                                        <td>{{ $cardon->height }}</td>
                                        <td>{{ $cardon->layer }}</td>
                                        <td>{{ $cardon->salary_percent }} %</td>
                                        <td>{{ nf($cardon->price) }}</td>
                                        <td>{{ $cardon->quantity }}</td>
                                        <td>
                                            {{-- {{ nf($cardon->quantity * $cardon->price) }} --}}
                                            <?php $this_total = $cardon->quantity * $cardon->price; ?>
                                            {{ nf($this_total) }}
                                            <?php $total += $this_total; ?>
                                        </td>
                                        <td>
                                            <form action="{{ route('cardons.destroy', $cardon->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="btn-group">
                                                    <a href="{{ route('cardons.show', $cardon->id) }}" class="btn  btn-sm btn-success">
                                                        <i class="bx bx-show
                                                        "></i>
                                                    </a>
                                                    <a href="{{ route('cardons.edit', $cardon->id) }}" class="btn  btn-sm btn-primary">
                                                        <i class="bx bx-edit
                                                        "></i>
                                                    </a>
                                                    <button type="submit" class="btn  btn-sm btn-danger">
                                                        <i class="bx bx-trash
                                                        "></i>
                                                    </button>
                                                </div>
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
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ $cardons->sum('quantity') }}</th>
                                        <th>{{ nf($total) }}</th>
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
@endsection

@push('js')
@endpush
