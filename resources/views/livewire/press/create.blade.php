<div class="row">
    <div wire:loading class="col-12">
		<div class="spinner-border text-primary" role="status">
			<span class="visually-hidden">Loading...</span>
		</div>
	</div>
    <div class="col-12">
        <form class="row" enctype="multipart/form-data" wire:submit.prevent="store">
            <div class="col-md-6">
                <label for="product_id">Продукт</label>
                <select class="form-select" wire:model="product_id">
                    <option value="">Выберите продукт</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ nf($product->quantity) }})</option>
                    @endforeach
                </select>
                @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="quantity">Количество (кг)</label>
                <input type="number" class="form-control" wire:model="quantity">
                @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-6 mt-2">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" style="max-height: 100px;">
                    <button type="button" class="btn btn-danger btn-sm" wire:click="removeImage">Удалить</button>
                @endif
                <input type="file" class="dropify" accept="image/*" wire:model="image">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-6 mt-2">
                <div wire:ignore>
                <label for="user_id">Пользователь</label>
                <select class="form-select" wire:model="user_ids" multiple id="select2">
                    <option value="">Выберите пользователя</option>
                    @foreach (getUsers(['presser']) as $user)
                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                    @endforeach
                </select>
                </div>
                @error('user_ids') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-12 mt-2">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    Livewire.on('initSelect2', function() {
        $(document).ready(function() {
            $("#select2").on("change", function (e) {
                @this.set('user_ids', $(this).val());
            });
            $('#select2').select2({
                maximumSelectionLength: 2
            });
        });
    });

</script>
@endpush
