@extends('templates.main')

@section('title_page')
    Roles
@endsection

@section('breadcrumb_title')
    roles
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Roles</div>
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-plus"></i> Role</a>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Roles Name</th>
                  <th>Guard Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($roles as $role)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $role->name }}</td>
                      <td>{{ $role->guard_name }}</td>
                      <td><a href="{{ route('roles.edit', $role->id) }}"><i class="fas fa-edit"></i></a></td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

@endsection