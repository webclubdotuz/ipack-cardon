@extends('layouts.main')
@push('css')
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Производство коробки'">
    <a href="{{ route('cardons.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::open(['route' => 'manufactures.store', 'method' => 'POST', 'class' => 'row']) }}
    <div class="col-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-12">
                            @foreach (getCardons() as $cardon)
                            <input class="btn-check" type="radio" name="cardon_id" id="{{ $cardon->id }}" value="{{ $cardon->id }}" required>
                            <label class="btn btn-outline-success btn-sm d-inline-block" for="{{ $cardon->id }}">
                                {{ $cardon->name }}
                            </label>
                            @endforeach
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Количество <span class="text-danger">*</span></label>
                                        {{ Form::text('quantity', null, ['class' => 'form-control', 'placeholder' => 'Количество', 'autocomplete' => 'off', 'required', 'min' => 1]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('description', 'Описание', ['class' => 'form-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Описание', 'autocomplete' => 'off', 'rows' => 1]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <label for="created_at" class="form-label">Дата <span class="text-danger">*</span></label>
                    {{ Form::date('created_at', date('Y-m-d'), ['class' => 'form-control', 'required']) }}
                </div>

                <div class="col-12">
                    {{ Form::submit('Создать', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

    <div class="col-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    @livewire('manufacture.index')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: 'Выберите продукт',
            allowClear: true,
            language: {
                noResults: function() {
                    return 'Ничего не найдено';
                },
            },
        });
    });

    $("#addRow").click(function() {
        let html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="in_price_lists[]" class="form-control money m-input" placeholder="Цена закупки" autocomplete="off">';
        html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bx bx-trash"></i></button>';
        html += '</div>';

        $('#newRow').append(html);
    });

    $(document).on('click', '#removeRow', function() {
        $(this).closest('#inputFormRow').remove();
    });
</script>
@endpush
