@extends('layouts.main')
@push('css')
    <!--plugins-->
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <b>Кардон:</b> {{ $cardon->name }} <br>
                                <b>Количество:</b> {{ $cardon->quantity }} <br>
                                <b>Зарплата:</b> {{ $cardon->salary }} <br>
                                <b>Цена:</b> {{ $cardon->price }} <br>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <b>Длина:</b> {{ $cardon->length }} <br>
                                <b>Ширина:</b> {{ $cardon->width }} <br>
                                <b>Высота:</b> {{ $cardon->height }} <br>
                                <b>Слой:</b> {{ $cardon->layer }} <br>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            @include('components.alert')
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-tab.nav>
                        <x-tab.li :id="'sales'" :title="'Продажи'" :active="true" :icon="'bx bx-shopping-bag'" />
                        <x-tab.li :id="'manufactures'" :title="'Производства'" :icon="'bx bx-factory'" />
                    </x-tab.nav>

                    <div class="tab-content py-3">
                        <x-tab.content :id="'sales'" :active="true">
                            @livewire('cardon.sale-list', ['cardon' => $cardon])
                        </x-tab.content>
                        <x-tab.content :id="'manufactures'">
                            @livewire('cardon.manufacture-list', ['cardon' => $cardon])
                        </x-tab.content>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
