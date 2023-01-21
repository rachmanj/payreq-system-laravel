<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-text">PC Balance</span>
                    <h4 class="description-header">Rp.{{ number_format($accounts->where('account_no', '111111')->first()->balance) }} <small>(PC)</small></h4>
                    {{-- <h5 class="description-header">Rp.{{ number_format($accounts->where('account_no', '111115')->first()->balance) }} <small>(DNC)</small></h5> --}}
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-text">Wait Payment</span>
                      <h5 class="description-header">Rp.{{ number_format($wait_payment->sum('payreq_idr'), 0) }}</h5>
                      <span class="description-percentage">{{ number_format($wait_payment->count(), 0) }} payreqs</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-text">Today Outgoing</span>
                      <h5 class="description-header">Rp.{{ number_format($today_outgoings->sum('payreq_idr'), 0) }}</h5>
                      <span class="description-percentage">(exclude DNC)</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                      <span class="description-text">This Year Avg Days</span>
                      <h5 class="description-header">{{ $yearly_average_days }}</h5>
                      <span class="description-percentage">(Outgoing to Verify Date)</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
        </div>
    </div>
</div>