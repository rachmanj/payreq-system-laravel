<div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h4>Rp.{{ number_format($this_month_payreqs->sum('payreq_idr'), 0) }}</h4>

        <p>This Month Outgoing</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h4>Rp.{{ number_format($this_year_payreqs->sum('payreq_idr'), 0) }}</h4>

        <p>This Year Outgoing</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h4>Rp.{{ number_format($this_year_realization, 0) }}</h4>

        <p>This Year Realization</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->