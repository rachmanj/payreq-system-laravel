<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\AdvanceCategory;
use App\Models\Department;
use App\Models\Payreq;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAccountingController extends Controller
{
    public function index()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $today = Carbon::now();

        return view('accounting-dashboard.index', [
            'today_outgoings' => Payreq::whereYear('outgoing_date', $today)->whereMonth('outgoing_date', $today)->whereDate('outgoing_date', $today),
            'this_month_outgoings' => Payreq::whereYear('outgoing_date', $today)->whereMonth('outgoing_date', $today)->where('user_id', '<>', $dnc_id),
            'months' => $this->get_month(),
            'this_year_outgoings' => $this->this_year_outgoings(),
            'get_months_this_year_outgoings' => $this->this_year_outgoings()['amounts'],
            'monthly_average_days' => $this->monthly_average_days(),
            'yearly_average_days' => $this->yearly_average_days()->where('year', Carbon::now()->format('Y'))->first() ? number_format($this->yearly_average_days()->where('year', Carbon::now()->format('Y'))->first()->avg_days, 2) : '-',
            'categories' => $this->get_payreq_categories(),
            'byCategories' => $this->payreqs_by_categories(),
            'departments' => Department::orderBy('akronim', 'asc')->get(),
            'department_months' => $this->get_department_months(),
            'payreq_departments' => $this->get_payreq_departments(),
            'byDepartments' => $this->payreqs_by_department(),
            'personels' => Transaksi::select('created_by')->distinct()->get(),
            'activity_personels' => Activity::select('user_id')->whereYear('created_at', $today)->distinct()->get(),
            'activities_months' => $this->get_activities_months(),
            'activities_count' => $this->get_activities_count(),
            'payreqs_not_budgeted' => $this->get_payreqs_not_budgeted(),
            'accounts' => Account::all(),
            'wait_payment' => Payreq::whereNull('outgoing_date')->get(),
        ]);
    }

    public function get_month()
    {
        return Payreq::selectRaw('substring(outgoing_date, 6, 2) as month')
            ->whereYear('outgoing_date', Carbon::now())
            ->distinct('month')
            ->orderBy('month', 'asc')
            ->get();
    }

    public function this_year_outgoings_old()
    {
        $monthly = Payreq::select(
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month"),
            DB::raw("(SUM(payreq_idr)) as amount")
        )
            ->whereYear('outgoing_date', Carbon::now()->subYear())
            ->whereNotNull('outgoing_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%m')"))
            ->get();

        return $monthly;
    }

    public function get_payreq_categories()
    {
        $categories = AdvanceCategory::whereHas('payreqs', function ($query) {
            $query->whereYear('outgoing_date', Carbon::now());
        })->orderBy('code', 'asc')->get();

        return $categories;
    }

    public function payreqs_by_categories()
    {
        $advances = Payreq::with('department')->selectRaw('advance_category_id, user_id, substring(outgoing_date, 6, 2) as month, payreq_idr')
            ->whereYear('outgoing_date', Carbon::now())
            ->get();

        return $advances;
    }

    public function get_activities_count()
    {
        $activities_count = Activity::select(
            "user_id",
            DB::raw("(count(user_id)) as total_count"),
            DB::raw("(DATE_FORMAT(created_at, '%m')) as month")
        )
            ->orderBy('created_at')
            ->whereYear('created_at', Carbon::now())
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m'), user_id"))
            ->get();

        return $activities_count;
    }

    public function get_activities_months()
    {
        $activities_months = Activity::select(
            DB::raw("(DATE_FORMAT(created_at, '%m')) as month")
        )
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->orderBy('created_at')
            ->distinct()
            ->get();

        return $activities_months;
    }

    public function get_department_months()
    {
        $department_months = Payreq::select(
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month")
        )
            ->whereNotNull('outgoing_date')
            ->orderBy('month')
            ->distinct()
            ->get();

        return $department_months;
    }

    public function get_payreq_departments()
    {
        $departments = Department::select('akronim')->whereHas('payreqs', function ($query) {
            $query->whereYear('outgoing_date', Carbon::now());
        })->distinct()->orderBy('akronim', 'asc')->get();

        return $departments;
    }

    public function payreqs_by_department()
    {
        $payreqs = Payreq::with('department')->selectRaw('user_id, substring(outgoing_date, 6, 2) as month, payreq_idr')
            ->whereYear('outgoing_date', Carbon::now())
            ->get();

        return $payreqs;
    }

    public function get_payreqs_not_budgeted()
    {
        $dnc_id = User::where('username', 'dncdiv')->first()->id;
        $outgoing_amount = Payreq::select(
            DB::raw("(sum(payreq_idr)) as total_amount"),
            DB::raw("(DATE_FORMAT(approve_date, '%Y-%m')) as month")
        )
            ->where('budgeted', 0)
            ->where('user_id', '<>', $dnc_id)
            ->groupBy(DB::raw("DATE_FORMAT(approve_date, '%Y-%m')"))
            ->get();

        return $outgoing_amount;
    }

    public function this_year_payreqs_count()
    {
        return Payreq::select(
            DB::raw("(count(id)) as total_count"),
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month")
        )
            ->whereYear('outgoing_date', Carbon::now())
            ->whereNotNull('outgoing_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%m')"))
            ->get();
    }

    public function monthly_average_days()
    {
        return Payreq::select(
            DB::raw("AVG(DATEDIFF(verify_date, outgoing_date)) as avg_days"),
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month")
        )
            ->whereYear('outgoing_date', Carbon::now())
            ->whereNotNull('verify_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%m')"))
            ->get();
    }

    public function yearly_average_days()
    {
        return Payreq::select(
            DB::raw("AVG(DATEDIFF(verify_date, outgoing_date)) as avg_days"),
            DB::raw("(DATE_FORMAT(outgoing_date, '%Y')) as year")
        )
            // ->whereYear('outgoing_date', Carbon::now()->subYear())
            ->whereNotNull('verify_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%Y')"))
            ->get();
    }

    public function this_year_outgoings()
    {
        $year = Carbon::now()->format('Y');
        $amounts = Payreq::select(
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month"),
            DB::raw("(SUM(payreq_idr)) as amount")
        )
            ->whereYear('outgoing_date', $year)
            ->whereNotNull('outgoing_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%m')"))
            ->get();

        $counts = Payreq::select(
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month"),
            DB::raw("(COUNT(*)) as lembars")
        )
            ->whereYear('outgoing_date', $year)
            ->whereNotNull('outgoing_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%m')"))
            ->get();

        $averages = Payreq::select(
            DB::raw("AVG(DATEDIFF(verify_date, outgoing_date)) as avg_days"),
            DB::raw("(DATE_FORMAT(outgoing_date, '%m')) as month")
        )
            ->whereYear('outgoing_date', $year)
            ->whereNotNull('verify_date')
            ->groupBy(DB::raw("DATE_FORMAT(outgoing_date, '%m')"))
            ->get();

        $monthly = [
            'amounts' => $amounts,
            'counts' => $counts,
            'averages' => $averages,
        ];

        return $monthly;
    }

    public function test()
    {
        //WAIT PAYMENT
        $wait_payment = Payreq::whereNull('outgoing_date')->sum('payreq_idr');
        return $wait_payment;
    }
}
