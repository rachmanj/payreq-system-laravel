<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header border-transparent">
                <h3 class="card-title"><b>Monthly Advance by Category</b></h3>
            </div>
            <div class="card-body p-0">
                <table class="table m-0 table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            @foreach ($months as $month)
                                <th class="text-center">{{ date('M', strtotime('2022-' . $month->month . '-01')) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($categories as $category)
                           <tr>
                                <td>{{ $category->code }}</td>
                                    @foreach ($months as $month)
                                        <td class="text-right">{{ number_format($byCategories->where('month', $month->month)->where('advance_category_id', $category->id)->sum('payreq_idr'), 0) }}</td>
                                    @endforeach
                           </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">

    </div>
</div>