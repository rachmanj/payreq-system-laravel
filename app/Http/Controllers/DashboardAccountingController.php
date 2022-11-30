<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\AdvanceCategory;
use App\Models\Department;
use App\Models\Payreq;
use App\Models\Transaksi;
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
            'categories' => $this->get_payreq_categories(),
            'byCategories' => $this->payreqs_by_categories(),
            'departments' => Department::orderBy('akronim', 'asc')->get(),
            'department_months' => $this->get_department_months(),
            'payreq_departments' => $this->get_payreq_departments(),
            'byDepartments' => $this->payreqs_by_department(),
            'personels' => Transaksi::select('created_by')->distinct()->get(),
            'activity_personels' => Activity::select('user_id')->whereYear('created_at', Carbon::now())->distinct()->get(),
            'activities_months' => $this->get_activities_months(),
            'activities_count' => $this->get_activities_count()
        ]);
    }

    public function get_month()
    {
        return Payreq::selectRaw('substring(outgoing_date, 6, 2) as month')
            ->whereYear('outgoing_date', Carbon::now())
            ->distinct('month')
            ->get();
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

    public function test2()
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

    public function test()
    {
        $activities_months = Activity::select(
            'user_id'
        )
            ->orderBy('created_at')
            ->distinct()
            ->get();

        return $activities_months;
    }
}
