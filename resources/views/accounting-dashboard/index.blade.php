@extends('templates.main')

@section('title_page')
    Payreqs Dashboard
@endsection

@section('breadcrumb_title')
    dashboard
@endsection

@section('content')

    {{-- ROW 1a --}}
    <div class="row">
        {{-- @include('accounting-dashboard.total-this-month-outs') --}}
        @include('accounting-dashboard.rekaps')
    </div>
    {{-- END ROW 1 --}}

    {{-- ROW 1b --}}
    <div class="row">
        @include('accounting-dashboard.rekaps_dnc')
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
        <div class="col-6">
            @include('accounting-dashboard.monthly-outgoing')
        </div>
        <div class="col-4">
            @include('accounting-dashboard.not-budgeted')
        </div>
    </div>
    {{-- END ROW 3 --}}

    {{-- ROW 5 CHART --}}
    <div class="row">
        <div class="col-12">
            @include('accounting-dashboard.chart')
        </div>
    </div>
    {{-- END ROW 5 CHART --}}

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

@section('scripts')
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
    // tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>

 {{-- CHART SCRIPT --}}
<script>
$(function () {
    'use strict'
  
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }
  
    var mode = 'index'
    var intersect = true

    let outgoings = {!! json_encode($chart_outgoings) !!};
    var bulans = outgoings.map(function(obj) {
        return obj.month;
    });
    var monthNames = bulans.map(function(bulan) {
        var date = new Date(`2000-${bulan}-01`);
        return date.toLocaleString('default', { month: 'short' });
    });
    
    var amounts = outgoings.map(function(obj) {
        return obj.amount;
    });

    var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: monthNames,
    //   labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: amounts
        //   data: [1000, 2000, 3000, 2500, 2700, 2500, 3000, 2500, 1500, 2000, 2500, 3000]
        },
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000000) {
                value /= 1000000
                value += 'Jt'
              }

              return '' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
})
</script>
@endsection