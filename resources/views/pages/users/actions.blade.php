<form action="" method="post">
    @csrf
    <div class="btn-group">
        <a href="{{ route('users.show', $value) }}" class="btn btn-sm btn-success"><i class="bx bx-show"></i></a>
        @if(hasRoles())
        <a href="{{ route('users.edit', $value) }}" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>
        <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
        <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('auth{{ $value }}').submit()"><i class="bx bx-key"></i></button>
        <button type="button" class="btn btn-sm btn-info" wire:click="$dispatch('balansModal', { user_id: {{ $value }} })"><i class="bx bx-money"></i></button>
        @endif
    </div>
</form>

<form action='{{ route('users.auth.admin', $value) }}' method='POST' class='d-inline' id="auth{{ $value }}">
    @csrf
</form>
