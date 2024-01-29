<div class="row">
	<div class="col-12">
		<div class="row">
			<div class="col-md-6">
				<label for="contact_id" class="form-label">Поставщик <span class="text-danger">*</span></label>
				<select name="contact_id" id="contact_id" class="form-select" wire:model="contact_id" required>
					<option value="">Выберите поставщика</option>
					@foreach(getSuppliers(['supplier', 'both']) as $contact)
					<option value="{{ $contact->id }}">{{ $contact->fullname }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
</div>
