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
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Продукт</th>
                                        <th>Цена</th>
                                        <th>Количество</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-active">
                                        <td>
                                            Рулоны
                                        </td>
                                        <td></td>
                                        <td>{{ $roll_count }} шт</td>
                                        <td></td>
                                    </tr>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ nf($product->price) }}</td>
                                        <td>{{ $product->quantity }} {{ $product->unit }}</td>
                                        <td>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="btn-group">
                                                    <a href="{{ route('products.show', $product->id) }}" class="btn  btn-sm btn-success">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn  btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <button type="submit" class="btn  btn-sm btn-danger">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </form>
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
@endsection
