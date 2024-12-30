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
                                        <td>{{ $product->quantity }} / {{ $product->unit }}</td>
                                        <td>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="btn-group">
                                                    <button type="button" class="btn  btn-sm btn-danger" onclick="initProductModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->quantity }}, '{{ $product->unit }}')">
                                                        <i class="bx bx-minus"></i>
                                                    </button>

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

    <!-- Modal -->
    <div class="modal fade" id="usedModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Использованные продукты</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <p>
                                Продукт: <span id="product-name"></span> <br>
                                Цена: <span id="product-price"></span> <br>
                                Количество: <span id="product-quantity"></span> <span id="product-unit"></span> <br>
                            </p>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('product-used.store') }}" method="post">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="quantity">Количество</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control form-control-sm" required step="any">
                                    </div>
                                    <div class="col-12">
                                        <label for="description">Описание</label>
                                        <textarea name="description" id="description" class="form-control form-control-sm" rows="3"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="created_at">Дата</label>
                                        <input type="date" name="created_at" id="created_at" class="form-control form-control-sm" required>
                                    </div>
                                    <input type="hidden" name="product_id" id="product_id" required>
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
    function initProductModal(id, name, price, quantity, unit) {
        $('#product-name').text(name);
        $('#product-price').text(price);
        $('#product-quantity').text(quantity);
        $('#product-unit').text(unit);

        $('#product_id').val(id);
        $('#quantity').attr('max', quantity);

        $('#usedModal').modal('show');
    }
</script>
@endpush
