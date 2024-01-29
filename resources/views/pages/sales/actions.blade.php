<form action="" method="post">
    @csrf
    <div class="btn-group">
        <a href="{{ route('users.show', $value) }}" class="btn btn-sm btn-success"><i class="bx bx-show"></i></a>
        @if(hasRoles())
        <a href="{{ route('users.edit', $value) }}" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a>
        <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
        @endif
    </div>
</form>
