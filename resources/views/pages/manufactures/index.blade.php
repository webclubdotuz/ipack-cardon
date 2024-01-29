@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Коробка производства'">
        <a href="{{ route('manufactures.create') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-plus"></i>
            Добавить производство
        </a>
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            @livewire('manufacture.index')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
