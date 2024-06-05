@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Продукты'">
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-plus"></i>
            Добавить
        </a>
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="get" class="row">
                        <div class="col-md-6">
                            <label for="start_date">Дата начала</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ $start_date }}">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date">Дата окончания</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ $end_date }}">
                        </div>

                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-primary">Применить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Продукт</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_useds as $product_used)
                                    <tr>
                                        <td>{{ $product_used->product->name }}</td>
                                        <td>{{ nf($product_used->price) }}</td>
                                        <td>{{ $product_used->quantity }} {{ $product_used->product->unit }}</td>
                                        <td>
                                            {{ nf($product_used->total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Итого</td>
                                    <td>{{ nf($product_useds->sum('total')) }}</td>
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
    </script>
@endpush
