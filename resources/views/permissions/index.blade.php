@extends('templates.main')

@section('title_page')
    Permissions
@endsection

@section('breadcrumb_title')
    permissions
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Permissions</div>
            <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal-input"><i class="fas fa-plus"></i> Permission</button>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Permission Name</th>
                  <th>Guard Name</th>
                  {{-- <th>Action</th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $permission->name }}</td>
                      <td>{{ $permission->guard_name }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-input">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> New Permission</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
          <div class="modal-body">
              <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" name='name' class="form-control" autofocus>
              </div>          
              <div class="form-group">
                <label for="guard_name">Guard Name</label>
                <input type="text" name='guard_name' class="form-control">
              </div>
          </div>
          <div class="modal-footer float-left">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
          </div>
        </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
@endsection