@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Баланс'"></x-breadcrumb>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Сырье остаток</td>
                                <td>{{ nf($product_summa) }}</td>
                            </tr>
                            <tr>
                                <td>Рулоны остаток</td>
                                <td>{{ nf($roll_summa) }}</td>
                            </tr>
                            <tr>
                                <td>Коробка остаток</td>
                                <td>{{ nf($cardon_summa) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Итого</td>
                                <td>{{ nf($product_summa + $roll_summa + $cardon_summa) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
