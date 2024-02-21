@extends('layouts.main')
@push('css')
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Создать кардон'">
    <a href="{{ route('cardons.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::open(['route' => 'cardons.store', 'method' => 'POST', 'class' => 'row']) }}
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
                        <div class="col-md-3">
                            <label for="price" class="form-label">Цена продажи</label>
                            <input type="number" name="price" id="price" class="form-control" required step="any">
                        </div>
                        <div class="col-md-3">
                            <label for="salary_percent" class="form-label">Зарплата %</label>
                            <input type="number" name="salary_percent" id="salary_percent" class="form-control" required min="0" max="100" step="any">
                        </div>
                        <div class="col-md-4">
                            <label for="width" class="form-label">Ширина</label>
                            <input type="number" name="width" id="width" class="form-control" required step="any">
                        </div>
                        <div class="col-md-4">
                            <label for="length" class="form-label">Длина</label>
                            <input type="number" name="length" id="length" class="form-control" required step="any">
                        </div>
                        <div class="col-md-4">
                            <label for="layer" class="form-label">Слой</label>
                            <input type="number" name="layer" id="layer" class="form-control" required step="any">
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
