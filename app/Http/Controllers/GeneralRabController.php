<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\GeneralRab;
use App\Models\Payreq;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralRabController extends Controller
{
    public function index()
    {
        return view('genrab.index');
    }

    public function dashboard()
    {
        return view('genrab.dashboard');
    }

    public function create()
    {
        $roles = User::find(Auth::user()->id)->getRoleNames()->toArray();

        if (count(array_intersect(['superadmin', 'admin'], $roles)) > 0) {
            $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];
            $departments = Department::orderBy('department_name')->get();
        } else {
            $projects = [User::find(Auth::user()->id)->project];
            $departments = Department::where('id', User::find(Auth::user()->id)->department_id)->get();
        }
        $nomor = $this->create_nomor();

        return view('genrab.create', compact('projects', 'departments', 'nomor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required',
            'description' => 'required',
            'project_code' => 'required',
            'department_id' => 'required',
            'amount' => 'required',
        ]);

        if ($request->file_upload) {
            $file = $request->file('file_upload');
            $filename = rand() . '_' . $file->getClientOriginalName();
            $file->move(public_path('document_upload'), $filename);
        } else {
            $filename = null;
        }

        $rab = new GeneralRab();
        $rab->nomor = $this->create_nomor();
        $rab->project_code = $request->project_code;
        $rab->department_id = $request->department_id;
        $rab->description = $request->description;
        $rab->amount = $request->amount;
        $rab->filename = $filename;
        $rab->created_by = Auth::user()->id;
        $rab->status = 'submitted';
        $rab->save();

        return redirect()->route('genrab.index')->with('success', 'Data berhasil disimpan');
    }

    public function data()
    {
        $rabs = GeneralRab::orderBy('created_at', 'desc')->orderBy('rab_no', 'desc')->get();

        return datatables()->of($rabs)
            ->editColumn('date', function ($rab) {
                return date('d-m-Y', strtotime($rab->created_at));
            })
            ->editColumn('project_code', function ($rab) {
                return $rab->project_code . ' | ' . $rab->department->akronim;
            })
            ->editColumn('amount', function ($rab) {
                return number_format($rab->amount, 2);
            })
            /*
            ->editColumn('advance', function ($rab) {
                $payreq = Payreq::where('rab_id', $rab->id)
                    ->whereNotNull('outgoing_date')
                    ->whereNull('realization_date');
                return number_format($payreq->sum('payreq_idr'), 2);
            })
            ->editColumn('realization', function ($rab) {
                $payreq = Payreq::where('rab_id', $rab->id)
                    ->whereNotNull('realization_date');
                return number_format($payreq->sum('realization_amount'), 2);
            })
            ->addColumn('progress', function ($rab) {
                $payreqs = Payreq::where('rab_id', $rab->id)->get();
                $total_advance = $payreqs->whereNotNull('outgoing_date')->whereNull('realization_date')->sum('payreq_idr');
                $total_realization = $payreqs->whereNotNull('realization_date')->sum('realization_amount');
                $total_release = $total_advance + $total_realization;
                $progress = ($total_release / $rab->budget) * 100;
                return number_format($progress, 2) . '%';
            })*/
            ->addIndexColumn()
            ->addColumn('action', 'genrab.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create_nomor()
    {
        $nomor = str_pad(GeneralRab::count() + 1, 3, '0', STR_PAD_LEFT)   . '/' . auth()->user()->department->akronim . '-RAB/' . auth()->user()->project . '/' . Carbon::now()->addHours(8)->format('y');

        return $nomor;
    }
}
