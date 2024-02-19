@extends('layouts.main')
@push('css')
    <!--plugins-->
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
    <x-breadcrumb :title="$product->name">
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-list-ul"></i>
            Список
        </a>
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><b>Продукт</b></td>
                        <td>{{ $product->name }}</td>
                        <td><b>Количество</b></td>
                        <td>{{ $product->quantity }} {{ $product->unit }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            @include('components.alert')
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-tab.nav>
                        @if(!$product->shop)
                        <x-tab.li :id="'purchases'" :title="'Покупки'" :active="true" :icon="'bx bx-shopping-bag'" />
                        @endif
                        <x-tab.li :id="'manufactures'" :title="'Производства'" :icon="'bx bx-layer'" />
                        @if($product->shop)
                        <x-tab.li :id="'sales'" :title="'Продажи'" :icon="'bx bx-shopping-bag'" />
                        @endif
                    </x-tab.nav>

                    <div class="tab-content py-3">
                        @if(!$product->shop)
                        <x-tab.content :id="'purchases'" :active="true">
                            @livewire('product.purchase', ['product' => $product])
                        </x-tab.content>
                        @endif
                        <x-tab.content :id="'manufactures'">
                            @livewire('product.manufacture', ['product' => $product])
                        </x-tab.content>
                        @if($product->shop)
                        <x-tab.content :id="'sales'">
                            @livewire('product.sale', ['product' => $product])
                        </x-tab.content>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
