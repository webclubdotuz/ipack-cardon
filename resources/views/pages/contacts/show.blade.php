@extends('layouts.main')

@section('content')
<x-breadcrumb :title="$contact->fullname">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm" onclick="openContactCreate()">
        <i class="bx bx-plus"></i>Создать
    </button>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <td><b>ФИО</b></td>
                            <td>{{ $contact->fullname }}</td>
                            <td><b>Телефон</b></td>
                            <td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Адрес</b></td>
                            <td>{{ $contact->address }}</td>
                            <td><a href="{{ route('contacts.edit', $contact->id) }}"><i class="bx bx-edit font-size-16 align-middle mr-2"></i> Редактировать</a></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Баланс клиент: {{ nf($contact->customer_balance) }} <br>
                                Баланс поставщик: {{ nf($contact->supplier_balance) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <x-tab.nav>
                    <x-tab.li :id="'purchases'" :title="'Покупки'" :active="true" :icon="'bx bx-shopping-bag'"/>
                    <x-tab.li :id="'sales'" :title="'Продажи'" :icon="'bx bx-cart'"/>
                </x-tab.nav>

                <div class="tab-content py-3">
                    <x-tab.content :id="'purchases'" :active="true">
                        @livewire('contact.purchase', ['contact' => $contact])
                    </x-tab.content>
                    <x-tab.content :id="'sales'">
                        @livewire('contact.sale', ['contact' => $contact])
                    </x-tab.content>
                </div>
            </div>
        </div>
    </div>
    @livewire('transaction.payment')
    @livewire('transaction.change-status')
    @livewire('transaction.show')
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
