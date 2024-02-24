@extends('layouts.main')
@push('css')
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="$cardon->name">
    <a href="{{ route('cardons.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    <form action="{{ route('cardons.update', $cardon->id) }}" method="post" class="row">
    @csrf
    @method('PUT')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Название</label>
                            <input type="text" name="name" id="name" class="form-control" required value="{{ $cardon->name }}">
                        </div>
                        <div class="col-md-3">
                            <label for="price" class="form-label">Цена продажи</label>
                            <input type="number" name="price" id="price" class="form-control" required step="any" value="{{ $cardon->price }}">
                        </div>
                        <div class="col-md-3">
                            <label for="salary_percent" class="form-label">Зарплата %</label>
                            <input type="number" name="salary_percent" id="salary_percent" class="form-control" required min="0" max="100" step="any" value="{{ $cardon->salary_percent }}">
                        </div>
                        <div class="col-md-3">
                            <label for="length" class="form-label">Длина</label>
                            <input type="number" name="length" id="length" class="form-control" required step="any" value="{{ $cardon->length }}">
                        </div>
                        <div class="col-md-3">
                            <label for="width" class="form-label">Ширина</label>
                            <input type="number" name="width" id="width" class="form-control" required step="any" value="{{ $cardon->width }}">
                        </div>
                        <div class="col-md-3">
                            <label for="height" class="form-label">Высота</label>
                            <input type="number" name="height" id="height" class="form-control" required step="any" value="{{ $cardon->height }}">
                        </div>

                        <div class="col-md-3">
                            <label for="layer" class="form-label">Слой</label>
                            <input type="number" name="layer" id="layer" class="form-control" required value="{{ $cardon->layer }}" step="any">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
@endpush
