<?php

namespace App\Http\Controllers;

use App\Models\AdvanceCategory;
use App\Models\Payreq;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAccountingController extends Controller
{
    public function index()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $today = Carbon::now();
        $this_year_outgoings = Payreq::selectRaw('payreq_idr, substring(outgoing_date, 6, 2) as month')
            ->whereYear('outgoing_date', $today->year)
            ->where('user_id', '<>', $dnc_id)
            ->get();


        return view('accounting-dashboard.index', [
            'today_outgoings' => Payreq::whereDate('outgoing_date', $today),
            'this_month_outgoings' => Payreq::whereMonth('outgoing_date', $today)->where('user_id', '<>', $dnc_id),
            'months' => $this->get_month(),
            'this_year_outgoings' => $this_year_outgoings,
            'categories' => AdvanceCategory::orderBy('code', 'asc')->get(),
            'byCategories' => $this->advance_by_categories()->get(),
        ]);
    }

    public function get_month()
    {
        return Payreq::selectRaw('substring(outgoing_date, 6, 2) as month')
            ->whereYear('outgoing_date', Carbon::now())
            ->distinct('month')
            ->get();
    }

    public function advance_by_categories()
    {
        $advances = Payreq::selectRaw('advance_category_id, substring(approve_date, 6, 2) as month, payreq_idr')
            ->whereYear('approve_date', Carbon::now());

        return $advances;
    }

    public function test()
    {
        $advances = Payreq::selectRaw('advance_category_id, substring(approve_date, 6, 2) as month, payreq_idr')
            ->whereYear('approve_date', Carbon::now())
            ->get();

        return $advances;
    }
}
