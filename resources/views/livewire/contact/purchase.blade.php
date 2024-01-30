<div class="row g-3">
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <label for="date_from">Дата от</label>
                <input type="date" class="form-control" id="date_from" wire:model="start_date">
            </div>
            <div class="col-4">
                <label for="date_to">Дата до</label>
                <input type="date" class="form-control" id="date_to" wire:model="end_date">
            </div>
        </div>
    </div>

    <div class="col-12 table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Получатель</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->fullname }}</td>
                        <td>{{ nf($transaction->total) }}</td>
                        <td>{{ df($transaction->created_at, 'd.m.Y H:i') }}</td>
                        <td>
                            <div class="dropdown open">
                                <button class="btn bt-sm btn-primary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </button>
                                <div class="dropdown-menu" style="position: relative;">
                                    @if ($transaction->debt)
                                        <button type="button" class="m-2 btn-block btn btn-primary btn-sm"
                                            wire:click="$dispatch('openModal', { transaction_id: {{ $transaction->id }} })">
                                            <i class="bx bx-money"></i>[Оплатить]
                                        </button>
                                    @endif
                                    <button type="button" class="m-2 btn-block btn btn-sm btn-danger"
                                        wire:click="delete({{ $transaction->id }})" wire:confirm="Вы уверены?">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button" class="m-2 btn-block btn btn-success btn-sm"
                                        wire:click="$dispatch('openModalTransactionShow', { transaction_id: {{ $transaction->id }} })">
                                        <i class="bx bx-show"></i>[Показать]
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

