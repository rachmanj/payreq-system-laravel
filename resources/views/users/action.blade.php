<form action="{{ route('users.destroy', $model->id) }}" method="POST" id="delete-user">
    @csrf @method('DELETE')
</form>
<form action="{{ route('users.activate', $model->id) }}" method="POST" id='activate-user'>
    @csrf @method('PUT')
</form>
<form action="{{ route('users.deactivate', $model->id) }}" method="POST" id="deactivate-user">
    @csrf @method('PUT')
</form>
<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit-user-{{ $model->id }}">edit</button>
@if ($model->is_active == 1)
    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-danger" form="deactivate-user">deactivate
    </button>
@endif
@if ($model->is_active == 0)
    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-success" form="activate-user">
        activate
    </button>
@endif
<a href="{{ route('users.edit', $model->id) }}" class="btn btn-xs btn-info">roles</a>
@hasanyrole('admin')
<button class="btn btn-xs btn-danger" onclick="return confirm('Are You sure You want to delete this user?')" form='delete-user'>delete</button>
@endhasanyrole

<div class="modal fade" id="edit-user-{{ $model->id }}">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('users.update', $model->id) }}" method="POST">
          @csrf @method('PUT')
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" value="{{ $model->name }}">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="{{ $model->username }}" disabled>
              </div>
            <div class="form-group">
              <label for="password">Password <small>(biarkan kosong jika tidak berubah)</small></label>
              <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password <small>(biarkan kosong jika password tidak berubah)</small></label>
                <input type="password_confirmation" name="password_confirmation" class="form-control">
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
          </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->