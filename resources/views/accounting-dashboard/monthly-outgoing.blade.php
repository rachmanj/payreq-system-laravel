<div class="card card-info">
    <div class="card-header border-transparent">
        <h3 class="card-title"><b>Monthly Outgoings via Payreqs</b></h3>
    </div>
    <div class="card-body p-0">
        <table class="table m-0 table-striped table-bordered">
            <thead>
                <tr>
                    <th>Month</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Count</th>
                    <th class="text-right">Avg Days</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($months as $item)
                    <tr>
                        <td>{{ date('M', strtotime('2022-' . $item->month . '-01')) }}</td>
                        <td class="text-right">{{ $this_year_outgoings->where('month', $item->month)->count() > 0 ? number_format($this_year_outgoings->where('month', $item->month)->sum('payreq_idr'), 0) : '-' }}</td>
                        <td class="text-right">{{ $this_year_outgoings->where('month', $item->month)->count() > 0 ? number_format($this_year_outgoings->where('month', $item->month)->count(), 0) : '-' }}</td>
                        <td class="text-right">{{ number_format($monthly_average_days->where('month', $item->month)->first()->avg_days, 2) }}</td>
                    </tr>
                @endforeach
                <th>Total</th>
                <th class="text-right">{{ number_format($this_year_outgoings->sum('payreq_idr'), 0) }}</th>
                <th class="text-right">{{ number_format($this_year_outgoings->count(), 0) }}</th>
                <th class="text-right">{{ $yearly_average_days }}</th>
            </tbody>
        </table>
    </div>
</div>