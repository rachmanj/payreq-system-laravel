@extends('templates.main')

@section('title_page')
    Payreqs Dashboard
@endsection

@section('breadcrumb_title')
    dashboard
@endsection

@section('content')

    @include('accounting-dashboard.row-1')
    @include('accounting-dashboard.row-2')
    @include('accounting-dashboard.row-3')

@endsection