<div>
    <div class="modal fade" id="ModalSalary" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Зарплата</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <x-alert />
                    @if($user)
                    <form class="col-12" wire:submit.prevent="save">
                        <div class="row g-2">
                            <div class="col-6">
                                <label>Оплата</label>
                                <input type="number" class="form-control" wire:model="amount" min="1" step="any">
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
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        Livewire.on('openSalary', () => {
            $('#ModalSalary').modal('show');
        });
    </script>
@endpush
