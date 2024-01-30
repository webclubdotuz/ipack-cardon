@extends('layouts.main')
@push('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <x-breadcrumb :title="'Покупка'">
        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-list-ul"></i>
            Список покупок
        </a>
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            @include('components.alert')
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('purchases.store') }}" method="post" class="row g-3">
                        @csrf
                        <div class="col-12" id="product-div">
                            <div class="row product-clone">
                                <div class="col-md-6">
                                    <label for="product_id_0">Продукт</label>
                                    <select name="products[][product_id]" id="product_id_0" class="form-select form-select-sm" required onchange="productChange(this, 0)">
                                        <option value="">Выберите продукт</option>
                                        @foreach (getProducts($shop=false) as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="price_0">Цена</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="products[][price]" id="price_0" class="form-control form-control-sm" step="any" required min="0" onkeyup="calculateTotal()">
                                        <span class="input-group-text">сум</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="total_0">Количество</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="products[][quantity]" id="quantity_0" class="form-control form-control-sm" step="any" required min="0" onkeyup="calculateTotal()">
                                        <span class="input-group-text" id="unit_0"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="total_0">Итого</label>
                                    <input type="text" name="products[][total]" id="total_0" class="form-control form-control-sm money" step="any" required min="0" readonly>
                                </div>
                                <div class="col-12">
                                    <a type="button" class="text-danger product-remove float-end"><i class="bx bx-trash"></i> Удалить</a> <br>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" id="add-product" onclick="return false;" class="text-primary  float-start"><i class="bx bx-plus"></i> Добавить продукт</a> <br>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_id">Поставщик</label>
                            <select name="contact_id" id="contact_id" class="form-control form-control-sm" required>
                                <option value="">Выберите поставщика</option>
                            @foreach (getContacts(['supplier', 'both']) as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="amount">Оплачено</label>
                            <input type="number" name="amount" id="amount" class="form-control form-control-sm" step="any" required min="0">
                        </div>
                        <div class="col-md-6">
                            <label for="method">Способ оплаты</label>
                            <select name="method" id="method" class="form-control form-control-sm" required>
                                <option value="">Выберите способ оплаты</option>
                                <option value="cash">Наличные</option>
                                <option value="card">Карта</option>
                                <option value="transfer">Перевод</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="description">Описание</label>
                            <textarea name="description" id="description" class="form-control form-control-sm" rows="2"></textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-sm btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/cloneData.js') }}"></script>

    <script>
        $('a#add-product').cloneData({
            mainContainerId: 'product-div', // Main container Should be ID
            cloneContainer: 'product-clone', // Which you want to clone
            removeButtonClass: 'product-remove', // Remove button for remove cloned HTML
            removeConfirm: true, // default true confirm before delete clone item
            removeConfirmMessage: 'Вы уверены что хотите удалить?', // confirm message
            minLimit: 1, // Default 1 set minimum clone HTML required
            maxLimit: 35, // Default unlimited or set maximum limit of clone HTML
            append: '<div>Hi i am appended</div>', // Set extra HTML append to clone HTML
            excludeHTML: ".exclude", // remove HTML from cloned HTML
            defaultRender: 1, // Default 1 render clone HTML
            init: function() {
                console.info(':: Initialize Plugin ::');
            },
            beforeRender: function() {
                console.info(':: Before rendered callback called');
            },
            afterRender: function() {
                console.info(':: After rendered callback called'); // Return clone object
            },
            afterRemove: function() {
                console.warn(':: After remove callback called');
            },
            beforeRemove: function() {
                console.warn(':: Before remove callback called');
            }
        });

        function calculateTotal() {

            let count = $('#product-div').find('.product-clone').length;

            for (let i = 0; i < count; i++) {
                let weight = $('#quantity_' + i).val();
                let price = $('#price_' + i).val();

                let total = weight * price;

                $('#total_' + i).val(total);
            }

            let total = 0;

            for (let i = 0; i < count; i++) {
                total += parseFloat($('#total_' + i).val());
            }

            $('#amount').val(total);
            $('#amount').attr('max', total);
        }

        // 200,00 -> 200
        function moneyToNumber(money) {
            return parseFloat(money.replace(',', '.'));
        }

        function productChange(e, index) {
            let product_id = $(e).val();
            $.ajax({
                url: '/api/products/' + product_id,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#price_' + index).val(moneyToNumber(response.price));
                    $('#unit_' + index).text(response.unit);
                    calculateTotal();
                }
            });
        }

    </script>
@endpush
