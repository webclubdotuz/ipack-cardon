<div>
    <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" wire:ignore.self>
        <x-alert />
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Заказ статус изменить</h5>
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
                            <form class="col-12" wire:submit.prevent="save">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label>Статус</label>
                                        <select class="form-control" wire:model.live="status">
                                            <option value="">Выберите статус</option>
                                            @foreach(getSaleStatus() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @foreach($transaction?->sales as $sale)
                                    <div class="col-6">
                                        <label><b>{{ $sale->product->name }}</b> <span class="text-success">{{ nf($sale->quantity, 2) }} кг</span></label>
                                        <input type="number" class="form-control" wire:model="losses.sale.{{ $sale->id }}">
                                    </div>
                                    <div class="col-6">
                                        <label>Комментарий</label>
                                        <textarea class="form-control" rows="1" wire:model="losses.sale_comment.{{ $sale->id }}"></textarea>
                                    </div>
                                    <hr>
                                    @endforeach
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary"><i class="bx bx-check"></i>Сохранить</button>
                                    </div>
                                </div>
                            </form>
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
            Livewire.on('openModalTransaction', () => {
                $('#changeStatus').modal('show');
            });
        });
    </script>
@endpush
