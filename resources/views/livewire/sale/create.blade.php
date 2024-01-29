<div class="row">
    <div wire:loading class="col-12">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

    </div>
    <div class="col-12 mb-3">
        @foreach (getProducts() as $product)
            <div class="dropdown d-inline-block m-1">
                <button class="btn btn-sm btn btn-outline-dark" type="button" data-bs-toggle="dropdown">
                    <i class="bx bx-cart"></i>
                    {{ $product->name }} ({{ nf($product->press_quantity) }} / {{ nf($product->press_quantity_kg) }} кг)
                </button>
                <div class="dropdown-menu p-2">
                    <input type="number" class="form-control" placeholder="кг" wire:model="quantity" step="any"
                        wire:keydown.enter="addCardQuantity({{ $product->id }})">
                    <button class="btn btn-sm btn btn-primary mt-2" wire:click="addCardQuantity({{ $product->id }})">
                        Добавить
                    </button>
                    <button class="btn btn-sm btn btn-success mt-2" wire:click="addCardPressAll({{ $product->id }})">
                        Все
                    </button>
                    <hr>
                    <div class="col-12">
                        @foreach (warehouse_presses($product->id) as $press)
                            <span class="badge bg-primary"
                                wire:click="addCardPress({{ $product->id }}, {{ $press->id }})">
                                {{ nf($press->quantity) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-12">
        <table class="table table-sm table-bordered" id="table">
            <thead>
                <tr>
                    <th>Продукт</th>
                    <th>Кол-во/Кг</th>
                    <th>Цена/Cумма</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($transaction)
                    @foreach ($transaction->sales as $sale)
                        <tr>
                            <td><b>{{ $sale->product->name }}</b></td>
                            <td>
                                {{ nf($sale->count) }} / {{ nf($sale->quantity) }}
                            </td>
                            <td>
                                {{ nf($sale->price) }} / {{ nf($sale->total) }}
                                <a class="text-primary" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <div class="dropdown-menu p-2">
                                    <input type="number" class="form-control" placeholder="price" wire:model="price"
                                        value="{{ nf($sale->price, 0, '', '') }}" step="any">
                                    <button class="btn btn-sm btn btn-primary mt-2"
                                        wire:click="editSalePrice({{ $sale->id }})">
                                        Сохранить
                                    </button>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click="showModal({{ $sale->id }})">
                                    <i class="bx bx-show"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <div class="row g-3">
            <div class="col-12">
                @if ($transaction)
                    Сумма: {{ nf($transaction->total) }}
                @endif
            </div>
            <div class="col-md-4">
                <label class="form-label">Клиент</label>
                <div class="input-group">
                    <select wire:model.live="contact_id" class="form-select">
                        <option value="">Выберите клиента</option>
                        @foreach (getContacts(['customer', 'both'], 1) as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->fullname }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary btn-sm" onclick="openContactCreate()">
                        <i class="bx bx-plus"></i>
                    </button>
                </div>
                @error('contact_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Статус</label>
                <select wire:model.live="status" class="form-select">
                    <option value="">Выберите статус</option>
                    @foreach (getSaleStatus() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label">Оплата</label>
                <input type="number" class="form-control" wire:model="amount">
                @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            @if ($contact_id)
                <div class="col-12">
                    <button class="btn btn-primary" wire:click="save">
                        Сохранить
                    </button>
                </div>
            @endif

            <div class="col-12">
                <button class="btn btn-danger" wire:click="cardClear">
                    Очистить
                </button>
            </div>
        </div>

    </div>

    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Детали продукта</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($saleShow)
                        <p>
                            <span class="fw-bold">Продукт:</span>
                            <span>{{ $saleShow->product->name }}</span>
                        </p>
                        <p>
                            <span class="fw-bold">Цена:</span>
                            <span>{{ nf($saleShow->price) }}</span>
                        </p>
                        <p>
                            <span class="fw-bold">Кол-во:</span>
                            <span>{{ nf($saleShow->count) }} / {{ nf($saleShow->quantity) }}</span>
                            <br>
                            <hr>
                        <div wire:ignore>
                            <select wire:model="saleItem_ids" class="form-select" multiple id="select2">
                                <option value="">Выберите пресс</option>
                                @foreach ($sale->saleItems as $saleItem)
                                    <option value="{{ $saleItem->id }}">{{ $saleItem->quantity }} кг</option>
                                @endforeach
                            </select>

                            <button class="btn btn-danger btn-sm mt-2" wire:click="deleteSaleItems">
                                Удалить
                            </button>
                        </div>
                        <hr>
                        @foreach ($sale->saleItems as $saleItem)
                            <span class="badge bg-primary" wire:click="deleteSaleItem({{ $saleItem->id }})"
                                wire:confirm="Вы уверены?">
                                {{ nf($saleItem->quantity) }} кг <span class="text-danger">x</span>
                            </span>
                        @endforeach
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @livewire('contact.create-or-update')
</div>

@push('js')
    <script>
        Livewire.on('showModal', () => {
            $('#showModal').modal('show');
        });
        Livewire.on('dismissModal', () => {
            $('#showModal').modal('hide');
        });


        Livewire.on('initSelect2', function() {
            console.log('initSelect2');
            // max 2 users
            $(document).ready(function() {
                $("#select2").on("change", function(e) {
                    @this.set('saleItem_ids', $(this).val());
                });
                $('#select2').select2({
                    dropdownParent: $('#showModal')
                });
            });
        });

        function openContactCreate() {
            Livewire.dispatch('openContactCreate');
        }
    </script>
@endpush
