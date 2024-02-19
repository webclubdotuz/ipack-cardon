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
    {{ Form::open(['route' => 'requests.store', 'method' => 'POST', 'class' => 'row']) }}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-6">
                            {{ Form::label('contact_id', 'Контакт') }}
                            {{ Form::select('contact_id', array(''=>'Выберите') + getContacts()->pluck('fullname', 'id')->toArray(), null, ['class' => 'form-control select2', 'required']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('deadline', 'Срок') }}
                            {{ Form::date('deadline', null, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="col-md-6">
                            <label for="cardon_id">Картон</label>
                            <select name="cardon_id" id="cardon_id" class="form-control select2" required>
                                <option value="">Выберите</option>
                                @foreach (getCardons() as $cardon)
                                    <option value="{{ $cardon->id }}">{{ $cardon->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="quantity">Количество</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>

                        <div class="col-12">
                            {{ Form::label('description', 'Описание') }}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'required']) }}
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

        $('#expense_category_id').change(function() {
            var user = $(this).find(':selected').data('user');
            console.log(user);
            if (user == 1) {
                $('#user_id_div').removeClass('d-none');
                $('#to_user_id').attr('required', true);
            } else {
                $('#user_id_div').addClass('d-none');
                $('#to_user_id').attr('required', false);
            }
        });

    </script>

@endpush
