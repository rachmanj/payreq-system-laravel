@extends('templates.main')

@section('title_page')
  General RAB  
@endsection

@section('breadcrumb_title')
    genrab
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        <a href="{{ route('genrab.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> New RAB</a>
      </div>  <!-- /.card-header -->
     
      <div class="card-body">
        <table id="genrab" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>RAB No</th>
            <th>Date</th>
            <th>Project | Dept</th>
            <th>Budget</th>
            {{-- <th>Advance</th>
            <th>Realization</th>
            <th>Progress</th> --}}
            <th></th>
          </tr>
          </thead>
        </table>
      </div> <!-- /.card-body -->
    </div> <!-- /.card -->
  </div> <!-- /.col -->
</div>  <!-- /.row -->

@endsection

@section('styles')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}"/>
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>

<script>
  $(function () {
    $("#genrab").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('genrab.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'rab_no'},
        {data: 'date'},
        {data: 'project_code'},
        {data: 'amount'},
        // {data: 'advance'},
        // {data: 'realization'},
        // {data: 'progress'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
      columnDefs: [
              {
                "targets": [4],
                "className": "text-right"
              }
            ]
    })
  });
</script>
@endsection