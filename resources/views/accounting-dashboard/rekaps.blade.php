<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
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
                  <div class="description-block border-right">
                      <span class="description-text">This Month Outgoing</span>
                      <h5 class="description-header">Rp.{{ number_format($this_month_outgoings->sum('payreq_idr')) }}</h5>
                      <span class="description-percentage">(exclude DNC)</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage"> - </span>
                    <h5 class="description-header"> - </h5>
                    <span class="description-text"> - </span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                      <span class="description-text">This Year Avg Days</span>
                      <h5 class="description-header">{{ number_format($yearly_average_days->avg_days, 2) }}</h5>
                      <span class="description-percentage">(Outgoing to Verify Date)</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
        </div>
    </div>
</div>