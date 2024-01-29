@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Клиенты'">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm" onclick="openContactCreate()">
        <i class="bx bx-plus"></i>Создать
    </button>
</x-breadcrumb>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                @livewire('contact-table')
                @livewire('contact.create-or-update')
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script>
    function openContactCreate() {
        Livewire.dispatch('openContactCreate');
    }

    function editContact(id) {
        Livewire.dispatch('editContact', id);
    }


</script>

@endpush
