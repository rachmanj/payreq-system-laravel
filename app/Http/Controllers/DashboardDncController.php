<?php

namespace App\Http\Controllers;

use App\Models\Payreq;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardDncController extends Controller
{
    public function index()
    {
        return view('dashboard-dnc.index', [
            // 'this_year_payreqs' =>  $this->dnc_payreqs_this_year()->get(),
            'this_year_release' => $this->this_year_release(),
            'this_month_outgoing' =>  $this->this_month_outgoing(),
            'monthly_outgoings_amount' => $this->outgoings_amount_by_month()
        ]);
    }

    public function dnc_payreqs_this_year()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $payreqs = Payreq::where('user_id', $dnc_id)->whereNotNull('rab_id')->whereNotNull('outgoing_date');

        return $payreqs;
    }

    public function realization_amount()
    {
        $type_other_amount = $this->dnc_payreqs_this_year()->where('payreq_type', 'Other')->sum('payreq_idr');
        $type_advance_amount = $this->dnc_payreqs_this_year()->whereNotNull('realization_date')->sum('realization_amount');

        return $type_other_amount + $type_advance_amount;
    }

    public function this_year_release()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $payreqs = Payreq::whereYear('outgoing_date', Carbon::now())
            ->where('user_id', $dnc_id)
            ->whereNotNull('rab_id')
            ->get();
        $total_advance = $payreqs->whereNotNull('outgoing_date')
            ->whereNull('realization_date')
            ->sum('payreq_idr');
        $total_realization = $payreqs->whereNotNull('realization_date')
            ->sum('realization_amount');
        $total_release = $total_advance + $total_realization;

        return number_format($total_release, 0);
    }

    public function this_month_outgoing()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $payreqs = Payreq::whereYear('outgoing_date', Carbon::now())
            ->whereMonth('outgoing_date', Carbon::now())
            ->where('user_id', $dnc_id)
            ->whereNotNull('rab_id')
            ->sum('payreq_idr');
        // $total_advance = $payreqs->sum('payreq_idr');

        return number_format($payreqs, 0);
    }

    public function outgoings_amount_by_month()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $outgoing_amount = Payreq::select(
            DB::raw("(sum(payreq_idr)) as total_amount"),
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month")
        )
            ->whereYear('outgoing_date', Carbon::now())
            ->where('user_id', $dnc_id)
            ->whereNotNull('rab_id')
            ->whereNotNull('outgoing_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%m')"))
            ->get();

        return $outgoing_amount;
    }

    public function test()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $payreqs = Payreq::whereYear('outgoing_date', Carbon::now())
            ->whereMonth('outgoing_date', Carbon::now())
            ->where('user_id', $dnc_id)
            ->whereNotNull('rab_id')
            ->get();
        $total_advance = $payreqs->whereNull('realization_date')
            ->sum('payreq_idr');
        $total_realization = $payreqs->whereNotNull('realization_date')
            ->sum('realization_amount');
        $total_release = $total_advance + $total_realization;

        return number_format($total_release, 0);
    }
}
