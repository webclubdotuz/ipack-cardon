@extends('layouts.main')
@push('css')
    <!--plugins-->
	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Создание расходной категории'">
    <a href="{{ route('invensts.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>

    {{-- {{ Form::open(['route' => 'invensts.store', 'method' => 'POST', 'class' => 'row']) }} --}}
    {{ Form::model($invenst, ['route' => ['invensts.update', $invenst->id], 'method' => 'PUT', 'class' => 'row']) }}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">

                        <div class="col-md-4">
                            {{ Form::label('amount', 'Сумма') }}
                            {{ Form::text('amount', null, ['class' => 'form-control money', 'required']) }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('method', 'Метод оплаты') }}
                            {{ Form::select('method', methods(), null, ['class' => 'form-control', 'required']) }}
                        </div>

                        <div class="col-12">
                            {{ Form::label('description', 'Описание') }}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
                        </div>

                        <div class="col-md-6">
                            {{ Form::label('date', 'Дата') }}
                            {{ Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'required']) }}
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

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Выберите',
                theme: 'bootstrap4'
            });
        });

    </script>

@endpush
