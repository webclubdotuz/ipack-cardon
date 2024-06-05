@extends('layouts.main')
@push('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <x-breadcrumb :title="'Покупка рулонов'">
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
                    <form action="{{ route('rolls.store') }}" method="post" class="row g-3">
                        @csrf
                        <div class="col-12" id="roll-div">
                            <div class="row roll-clone">
                                <div class="col-4">
                                    <label for="size_0">Формат</label>
                                    <input type="number" name="rolls[][size]" id="size_0" class="form-control form-control-sm" step="any" required min="0">
                                </div>
                                <div class="col-4">
                                    <label for="paper_weight_0">Плотность (гр)</label>
                                    <input type="number" name="rolls[][paper_weight]" id="paper_weight_0" class="form-control form-control-sm" step="any" required min="0">
                                </div>
                                <div class="col-4">
                                    <label for="weight_0">Вес (кг)</label>
                                    <input type="number" name="rolls[][weight]" id="weight_0" class="form-control form-control-sm" step="any" required min="0" onkeyup="calculateTotal()">
                                </div>
                                <div class="col-4">
                                    <label for="price_0">Цена за рулон</label>
                                    <input type="number" name="rolls[][price]" id="price_0" class="form-control form-control-sm" step="any" required min="0" onkeyup="calculateTotal()">
                                </div>
                                <div class="col-4">
                                    <label for="total_0">Итого</label>
                                    <input type="text" name="rolls[][total]" id="total_0" class="form-control form-control-sm money" step="any" required min="0" readonly>
                                </div>
                                <div class="col-4">
                                    <label for="glue_0">Клей</label>
                                    <select name="rolls[][glue]" id="glue_0" class="form-control form-control-sm" required>
                                        <option value="">Выберите клей</option>
                                        <option value="1">Есть</option>
                                        <option value="0">Нет</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <a type="button" id="add-roll" onclick="return false;" class="text-primary  float-start"><i class="bx bx-plus"></i> Добавить рулон</a>
                                    <a type="button" class="text-danger roll-remove float-end"><i class="bx bx-trash"></i> Удалить</a>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-4">
                            <label for="contact_id">Поставщик</label>
                            <select name="contact_id" id="contact_id" class="form-control form-control-sm" required>
                                <option value="">Выберите поставщика</option>
                            @foreach (getContacts(['supplier', 'both']) as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="amount">Оплачено</label>
                            <input type="number" name="amount" id="amount" class="form-control form-control-sm" step="any" required min="0">
                        </div>
                        <div class="col-4">
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
                            <label for="created_at">Дата</label>
                            <input type="date" name="created_at" id="created_at" class="form-control form-control-sm" required>
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
        $('a#add-roll').cloneData({
            mainContainerId: 'roll-div', // Main container Should be ID
            cloneContainer: 'roll-clone', // Which you want to clone
            removeButtonClass: 'roll-remove', // Remove button for remove cloned HTML
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

            let count = $('#roll-div').find('.roll-clone').length;

            for (let i = 0; i < count; i++) {
                let weight = $('#weight_' + i).val();
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


    </script>
@endpush
