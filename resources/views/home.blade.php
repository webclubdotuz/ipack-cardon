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

        <div class="col-md-6">
            <x-charts.multi-line-chart :id="'multiple-line-chart'" :title="'График покуки'" :labels="$dateRange" :series="$series" />
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3>Покупки</h3>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Товары</th>
                                <th>Покупки</th>
                                <th>Сумма</th>
                                <th>Остатка</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            @foreach ($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->product->name }}</td>
                                    <td>{{ nf($purchase->quantity) }}</td>
                                    <td>{{ nf(getPurchaseProduct($purchase->product->id, null, null)->sum('total')) }}</td>
                                    <td>{{ nf($purchase->product->quantity) }}</td>
                                </tr>
                            @endforeach
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <x-charts.multi-line-chart :id="'multiple-line-chart'" :title="'График покуки'" :labels="$dateRange" :series="$sales_series" />
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3>Продажи</h3>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Товары</th>
                                <th>Продажи</th>
                                <th>Сумма</th>
                                <th>Остатка</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ nf($sale->quantity) }}</td>
                                    <td>{{ nf(getSaleProduct($sale->product->id, null, null)->sum('total')) }}</td>
                                    <td>{{ nf($sale->product->quantity) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3>Производство</h3>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Товары</th>
                                <th>Производство</th>
                                <th>Сегодня</th>
                                <th>Остатка</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <?php

                            $roll_productions = \App\Models\RollProduction::selectRaw('roll_id, sum(quantity) as quantity')
                                ->whereBetween('created_at', [now()->startOfMonth(), now()])
                                ->groupBy('roll_id')
                                ->get();

                            $pakets = \App\Models\Paper::selectRaw('paket_id, sum(quantity) as quantity')
                                ->whereBetween('created_at', [now()->startOfMonth(), now()])
                                ->groupBy('paket_id')
                                ->get();
                            $papers = \App\Models\Paper::whereBetween('created_at', [now()->startOfMonth(), now()])
                            ->groupBy('product_id')
                            ->selectRaw('sum(quantity) as quantity, product_id')
                            ->get();

                            $etikats = \App\Models\RollProductionItem::whereBetween('created_at', [now()->startOfMonth(), now()])
                            ->groupBy('product_id')
                            ->selectRaw('sum(quantity) as quantity, product_id')
                            ->get();

                            ?>

                            @foreach ($bunker_items as $bunker_item)
                                <tr>
                                    <td>{{ $bunker_item->product->name }}</td>
                                    <td>{{ nf($bunker_item->quantity) }} {{ $bunker_item->product->unit }}
                                    <td>{{ nf(\App\Models\BunkerItem::where('product_id', $bunker_item->product_id)->whereDate('created_at', date('Y-m-d'))->sum('quantity')) }}</td>
                                    <td>{{ nf($bunker_item->product->quantity) }}</td>
                                </tr>
                            @endforeach

                            @foreach ($roll_productions as $roll_production)
                                <tr>
                                    <td>{{ $roll_production->roll->name }}</td>
                                    <td>{{ nf($roll_production->quantity) }} шт</td>
                                    <td>{{ nf(\App\Models\RollProduction::where('roll_id', $roll_production->roll_id)->whereDate('created_at', date('Y-m-d'))->sum('quantity')) }}</td>
                                    <td></td>
                                </tr>
                            @endforeach

                            @foreach ($etikats as $etikat)
                                <tr>
                                    <td>{{ $etikat->product->name }}</td>
                                    <td>{{ nf($etikat->quantity) }} {{ $etikat->product->unit }}</td>
                                    <td>{{ nf(\App\Models\RollProductionItem::where('product_id', $etikat->product_id)->whereDate('created_at', date('Y-m-d'))->sum('quantity')) }}</td>
                                    <td>{{ nf($etikat->product->quantity) }}</td>
                                </tr>
                            @endforeach

                            @foreach ($pakets as $paket)
                                <tr>
                                    <td>{{ $paket->paket->name }}</td>
                                    <td>{{ nf($paket->quantity) }} {{ $paket->paket->unit }}</td>
                                    <td>{{ nf(\App\Models\Paper::where('paket_id', $paket->paket_id)->whereDate('created_at', date('Y-m-d'))->sum('quantity')) }}</td>
                                    <td>{{ nf($paket->paket->quantity) }}</td>
                                </tr>
                            @endforeach

                            @foreach ($papers as $paper)
                                <tr>
                                    <td>{{ $paper->product->name }}</td>
                                    <td>{{ nf($paper->quantity) }} {{ $paper->product->unit }}</td>
                                    <td>{{ nf(\App\Models\Paper::where('product_id', $paper->product_id)->whereDate('created_at', date('Y-m-d'))->sum('quantity')) }}</td>
                                    <td>{{ nf($paper->product->quantity) }}</td>
                                </tr>
                            @endforeach
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
