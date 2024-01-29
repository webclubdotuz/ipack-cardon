<div>
    <div class="modal fade" id="ContactCreateOrUpdate" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="fullname" class="form-label">Fullname</label>
                            <input type="text" class="form-control" wire:model="fullname" placeholder="ФИО">
                            @error('fullname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" wire:model="phone" placeholder="Телефон">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" wire:model="address" placeholder="Адрес"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Тип</label>
                            <select class="form-select" wire:model="type">
                                <option value="">Выберите тип</option>
                                @if ($is_type == 'customer')
                                    <option value="customer">Клиент</option>
                                @else
                                    <option value="supplier">Поставщик</option>
                                @endif
                                <option value="both">Клиент и поставщик</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bx bx-x"></i>Закрыть</button>
                    <button type="button" class="btn btn-primary" wire:click="StoreOrUpdate()"><i
                            class="bx bx-check"></i>Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openContactCreate', () => {
                $('#ContactCreateOrUpdate').modal('show');
            });

            Livewire.on('editContact', () => {
                $('#ContactCreateOrUpdate').modal('show');
            });

            Livewire.on('contactCloseModal', () => {
                console.log('close');
                $('#ContactCreateOrUpdate').modal('hide');
                Livewire.dispatch('refreshContacts');
            });
        });
    </script>
@endpush
