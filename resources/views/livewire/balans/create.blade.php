<div>
    <div class="modal fade" id="balansModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Пополнение баланса</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" wire:submit.prevent="save" class="row g-3">
                        @if($user)
                        <div class="col-6">
                            <label for="user_id" class="form-label">Пользователь</label>
                            <input type="text" class="form-control" id="user_id" value="{{ $user->fullname }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="balance" class="form-label">Баланс</label>
                            <input type="text" class="form-control" id="balance" value="{{ nf($user->balance) }}" disabled>
                        </div>
                        @else
                        <div class="col-12">
                            <label for="user_id" class="form-label">Пользователь</label>
                            <select class="form-select" id="user_id" wire:model="user_id">
                                <option value="">Выберите пользователя</option>
                                @foreach (getUsers() as $user)
                                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        @endif
                        <div class="col-12">
                            <label for="amount" class="form-label">Сумма</label>
                            <input type="number" class="form-control" id="amount" wire:model="amount">
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <label for="comment" class="form-label">Комментарий</label>
                            <textarea class="form-control" id="comment" wire:model="comment"></textarea>
                            @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Пополнить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openModalBalans', () => {
                $('#balansModal').modal('show');
            });
        });
    </script>
@endpush
