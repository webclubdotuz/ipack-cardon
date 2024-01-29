@extends('layouts.main')
@push('css')
    <!--plugins-->
	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Создание пользователя'">
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::open(['route' => 'users.store', 'method' => 'POST', 'class' => 'row']) }}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="text-center">
                                <img src="/assets/images/avatar.png" alt="avatar" class="rounded-circle" width="100">
                            </div>
                            {{ Form::file('avatar', ['class' => 'form-control', 'accept' => 'image/*', 'id' => 'avatar']) }}
                        </div>
                        <div class="col-md-12">
                            {{ Form::label('roles', 'Роль', ['class' => 'form-label']) }}
                            {{ Form::select('roles[]', $roles->pluck('name', 'id'), null, ['class' => 'form-control select2', 'required', 'multiple']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-title px-3 py-1">
                <h4 class="text-primary text-center">Данные пользователя</h4>
                <hr>
            </div>
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-6">
                            {{ Form::label('fullname', 'ФИО', ['class' => 'form-label']) }}
                            {{ Form::text('fullname', null, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('phone', 'Телефон', ['class' => 'form-label']) }}
                            {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => '934879598', 'required', 'pattern' => '[0-9]{9}', 'maxlength' => '9']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('username', 'Логин', ['class' => 'form-label']) }}
                            {{ Form::text('username', null, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('password', 'Пароль', ['class' => 'form-label']) }}
                            {{ Form::password('password', ['class' => 'form-control', 'required']) }}
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
                theme: 'bootstrap4',
                placeholder: 'Выберите роль',
                allowClear: true
            });
        })

        $('#avatar').change(function() {
            let input = this;
            let url = $(this).val();
            let ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('.rounded-circle').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $('.rounded-circle').attr('src', '/assets/images/avatar.png');
            }
        })
    </script>
@endpush
