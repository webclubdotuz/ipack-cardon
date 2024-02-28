@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Конкакты'" :value="$contact_count" :icon="'bx bx-user'" :route="route('contacts.customers')" />
        </div>
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Долг клиентов'" :value="nf($sale_debt_sum)" :icon="'bx bx-money'" :route="route('contacts.customers')" />
        </div>
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Долг поставщиков'" :value="nf($purchase_debt_sum)" :icon="'bx bx-money'" :route="route('contacts.suppliers')" />
        </div>

        <div class="col-md-4">
            <x-widgets.static-widget :title="'Покупки'" :value="nf($purchase_sum)" :icon="'bx bx-money'" :route="route('purchases.index')" />
        </div>

        <div class="col-md-4">
            <x-widgets.static-widget :title="'Продажи'" :value="nf($sale_sum)" :icon="'bx bx-money'" :route="route('sales.index')" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-charts.line-chart :title="'Динамика продажи'" :labels="$paymentLabels" :data="$paymentData" />
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3>Продажи</h3>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Поступление</th>
                                <th>{{ nf($payment_methods->sum('sum')) }}</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment_methods as $payment_method)
                                <tr>
                                    <td>{{ methods()[$payment_method->method] }}</td>
                                    <td>{{ nf($payment_method->sum) }}</td>
                                    <td>{{ nf($payment_method->sum / $payment_methods->sum('sum') * 100) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-charts.column :title="'Производство'" :labels="$manufactureLabels" :data="$manufactureData" />
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3>Производство</h3>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Производство</th>
                                <th>{{ nf($manufactures->sum('quantity')) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manufactures as $manufactures)
                                <tr>
                                    <td>{{ $manufactures->cardon->name }}</td>
                                    <td>{{ nf($manufactures->quantity) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
