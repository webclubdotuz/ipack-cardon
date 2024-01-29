@extends('layouts.main')
@push('css')
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Создать продукт'">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::open(['route' => 'products.store', 'method' => 'POST', 'class' => 'row']) }}
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-6">
                            {{ Form::label('name', 'Название', ['class' => 'form-label']) }}
                            {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('price', 'Цена продажи', ['class' => 'form-label']) }}
                            {{ Form::text('price', null, ['class' => 'form-control money', 'required']) }}
                        </div>
                        <div class="col-md-12">
                            {{ Form::label('description', 'Описание', ['class' => 'form-label']) }}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
                        </div>
                        <div class="col-12">
                            <label for="shop">
                                <input type="checkbox" name="shop" id="shop" class="form-check-input">
                                Продажи
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {{ Form::submit('Создать', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>

@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
@endpush
