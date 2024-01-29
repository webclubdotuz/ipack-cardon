@extends('layouts.main')
@push('css')

@endpush
@section('content')
<x-breadcrumb :title="'Создание пользователя'">
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">

</div>

@endsection

@push('js')

@endpush
