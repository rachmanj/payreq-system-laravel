@extends('templates.main')

@section('title_page')
    Payreqs Dashboard
@endsection

@section('breadcrumb_title')
    dashboard
@endsection

@section('content')

    {{-- ROW 1 --}}
    <div class="row">
        @include('accounting-dashboard.total-this-month-outs')
    </div>
    {{-- END ROW 1 --}}

    {{-- ROW 2 --}}
    <div class="row">
        <div class="col-12">
            @include('accounting-dashboard.personel-activities')
        </div>
    </div>
    {{-- END ROW 2 --}}
    
    {{-- ROW 3 --}}
    <div class="row">
        <div class="col-4">
            @include('accounting-dashboard.monthly-outgoing')
        </div>
        <div class="col-4">
            @include('accounting-dashboard.not-budgeted')
        </div>
    </div>
    {{-- END ROW 3 --}}

    {{-- ROW 4 --}}
    <div class="row">
        <div class="col-12">
            @include('accounting-dashboard.adv-by-dept')
        </div>
    </div>
    {{-- END ROW 4 --}}

    {{-- ROW 5 --}}
    <div class="row">
        <div class="col-12">
            @include('accounting-dashboard.adv-by-category')
        </div>
    </div>
    {{-- END ROW 5 --}}



    {{-- @include('accounting-dashboard.row-3') --}}

@endsection