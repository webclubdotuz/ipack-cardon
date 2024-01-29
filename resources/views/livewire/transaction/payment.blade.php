<div>
    <div class="modal fade" id="openModalPayment" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Оплата</h5>
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

                            @if($transaction->debt > 0)
                            <hr>

                            <form class="col-12" wire:submit.prevent="save">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label>Оплата (максимум: {{ $transaction->debt }})</label>
                                        <input type="number" class="form-control" wire:model="amount" max="{{ $transaction->debt }}">
                                    </div>
                                    <div class="col-6">
                                        <label>Тип оплаты</label>
                                        <select class="form-control" wire:model="method">
                                            <option value="cash">Наличные</option>
                                            <option value="card">Карта</option>
                                            <option value="transfer">Перевод</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label>Комментарий</label>
                                        <textarea class="form-control" wire:model="description"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary"><i
                                            class="bx bx-check"></i>Сохранить</button>
                                    </div>
                                </div>
                            </form>
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
            Livewire.on('openModalPayment', () => {
                $('#openModalPayment').modal('show');
            });
        });
    </script>
@endpush
