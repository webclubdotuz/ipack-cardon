@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Пользователи'">
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-user-plus"></i>
        Добавить
    </a>
</x-breadcrumb>

<div class="row">

    <div class="col">
        <div class="card">
            <div class="card-body">
                @livewire('user-table')
            </div>
        </div>
    </div>

    @livewire('balans.create')
</div>

@endsection
