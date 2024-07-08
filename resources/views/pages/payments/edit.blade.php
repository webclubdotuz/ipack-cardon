@extends('layouts.main')
@push('css')
    <!--plugins-->
	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Редактировать оплату'">
    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::model($payment, ['route' => ['payments.update', $payment->id], 'method' => 'PUT', 'class' => 'row']) }}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="amount">Сумма</label>
                            {{ Form::text('amount', null, ['class' => 'form-control', 'id' => 'amount']) }}
                        </div>
                        <div class="col-md-6">
                            <label for="amount">Сумма</label>
                            {{ Form::select('method', methods(), null, ['class' => 'form-control select2']) }}
                        </div>
                        <div class="col-12">
                            <label for="description">Описание</label>
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
                        </div>

                        <div class="col-md-6">
                            <label for="created_at">Дата</label>
                            <input type="date" name="created_at" id="created_at" class="form-control"
                                value="{{ $payment->created_at->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {{ Form::submit('Сохранить', ['class' => 'btn btn-sm btn-primary']) }}
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
