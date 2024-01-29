@extends('layouts.main')
@push('css')
    <!--plugins-->
	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Создание расходной категории'">
    <a href="{{ route('expense-categories.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::model($expense_category, ['route' => ['expense-categories.update', $expense_category->id], 'method' => 'PUT', 'class' => 'row']) }}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-6">
                            {{ Form::label('name', 'Название') }}
                            {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('user', 'Пользователь') }}
                            {{ Form::select('user', ['' => 'Выберите', '1' => 'Да', '0' => 'Нет'], null, ['class' => 'form-control select2', 'required']) }}
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
