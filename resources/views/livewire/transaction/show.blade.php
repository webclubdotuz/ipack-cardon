<div>
    <x-alert />
    <div class="modal fade" id="TransactionShow" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Заказ</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($transaction)
                        <div class="row">
                            <div class="col-12">
                                <b>ФИО:</b> {{ $transaction->contact->fullname }} <br>
                                <b>Телефон:</b> {{ $transaction->contact->phone }} <br>
                                <hr>
                                <b>Сумма:</b> {{ nf($transaction->total) }} <br>
                                <b>Оплачено:</b> {{ nf($transaction->paid) }} <br>
                                @if($transaction->debt > 0)
                                    <b class="text-danger">Долг: {{ nf($transaction->debt) }}</b> <br>
                                @endif
                            </div>

                            <hr>
                            @if($transaction->type == 'purchase' || $transaction->type == 'roll')
                                <div class="col-12">
                                    <h5>Покупка</h5>
                                    <table class="table table-striped table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Поставщик</th>
                                                <th>Товары</th>
                                                <th>Сумма</th>
                                                <th>Дата</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $transaction->id }}</td>
                                                <td>
                                                    <a href="{{ route('contacts.show', $transaction->contact->id) }}">{{ $transaction->contact->fullname }}</a>
                                                </td>
                                                <td>
                                                    @foreach ($transaction->purchases as $purchase)
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                {{ $purchase->product->name }}
                                                            </div>
                                                            <div>
                                                                <a data-bs-toggle="dropdown" class="text-primary">
                                                                    {{ nf($purchase->quantity, 2) }} кг
                                                                </a>
                                                                <div class="dropdown-menu p-2">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <b>Цена:</b> {{ nf($purchase->price) }} сум <br>
                                                                            <b>Кол-во:</b> {{ nf($purchase->quantity, 2) }} кг <br>
                                                                            <b>Сумма:</b> {{ nf($purchase->total) }} сум <br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach ($transaction->rolls as $roll)
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                {{ nf($roll->size) }} cм / {{ nf($roll->paper_weight) }} гр / {{ nf($roll->weight) }} кг
                                                            </div>
                                                            <div>
                                                                <a data-bs-toggle="dropdown" class="text-primary">
                                                                    {{ nf($roll->total) }} сум
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>{{ nf($transaction->total, 2) }} {{ $transaction->debt_info }}</td>
                                                <td>{{ df($transaction->created_at, 'd.m.Y H:i') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            @if($transaction->type == 'sale')
                                <div class="col-12">
                                    <h5>Продажа</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Продукт</th>
                                                <th>Цена</th>
                                                <th>Кол-в</th>
                                                <th>Сумма</th>
                                                <th>Чистая кол-в</th>
                                                <th>Убытки</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->sales as $sale)
                                                <tr>
                                                    <td>{{ $sale->product->name }}</td>
                                                    <td>{{ nf($sale->price) }}</td>
                                                    <td>{{ nf($sale->quantity, 2) }} кг</td>
                                                    <td>{{ nf($sale->total,2) }}</td>
                                                    <td>{{ nf($sale->quantity_clean, 2) }} кг</td>
                                                    <td>{{ nf($sale->loss, 2) }} кг</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Итого</th>
                                                <th></th>
                                                <th>{{ nf($transaction->quantity, 2) }} кг</th>
                                                <th>{{ nf($transaction->total) }}</th>
                                                <th>{{ nf($transaction->quantity_clean, 2) }} кг</th>
                                                <th>{{ nf($transaction->loss, 2) }} кг</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif

                            @if($transaction->payments->count() > 0)
                                <div class="col-12">
                                    <h5>Оплаты</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Сумма</th>
                                                <th>Комментарий</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                                    <td>{{ nf($payment->amount) }}</td>
                                                    <td>{{ $payment->comment }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Итого</th>
                                                <th>{{ nf($transaction->paid) }}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openModalTransactionShowDis', () => {
                $('#TransactionShow').modal('show');
            });
        });
    </script>
@endpush
