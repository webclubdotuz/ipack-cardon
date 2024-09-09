<form action="" method="post">
    @csrf
    <div class="btn-group">
        <a href="{{ route('contacts.show', $value) }}" class="btn btn-sm btn-success"><i class="bx bx-show"></i></a>
        @if(hasRoles())
        <button class="btn btn-sm btn-primary" type="button" wire:click="$dispatchTo('contact.create-or-update', 'edit' , { id: {{ $value }} })">
            <i class="bx bx-edit"></i>
        </button>
        @endif
    </div>
</form>
