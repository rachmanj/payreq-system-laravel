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
                    <h3 class="card-title">New General RAB
                    </h3>
                    <a href="{{ route('genrab.index') }}" class="btn btn-sm btn-success float-right"><i class="fas fa-undo"></i> Back</a>
                </div>

                <form action="{{ route('genrab.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('POST')
                    <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="rab_no">RAB No</label>
                                    <input name="nomor" id="nomor" value="{{ $nomor }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="date_time">Date & Time <small>(Date & time will change according to the submit time)</small></label>
                                    <input name="date_time" id="date_time" class="form-control" value="{{ now()->addHours(8)->format('d/m/Y H:i:s') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" cols="30" rows="2" class="form-control @error('description') is-invalid @enderror">
                                        {{ old('description') }}
                                    </textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                        {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="project_code">Project</label>
                                    <select name="project_code" id="project_code" class="form-control">
                                        @foreach ($projects as $project)
                                            <option value="{{ $project }}">{{ $project }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_id" class="form-control">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->akronim . ' - ' . $department->department_name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="amount" >Amount <span class="text-danger">*</span></label>
                                    <input name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
                                    @error('amount')
                                        <div class="invalid-feedback">
                                        {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="file_upload">Upload RAB File</label>
                                    <input type="file" name="file_upload" id="file_upload" class="form-control @error('file_upload') is-invalid @enderror">
                                    @error('file_upload')
                                      <div class="invalid-feedback">
                                        {{ $message }}
                                      </div>
                                    @enderror
                                  </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection