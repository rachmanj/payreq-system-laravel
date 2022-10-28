<?php

namespace App\Http\Controllers;

use App\Models\Payreq;
use App\Models\Rab;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovedController extends Controller
{
    public function index()
    {
        return view('approved.index');
    }

    public function create()
    {
        $employees = User::orderBy('name', 'asc')->get();
        $rabs = Rab::where('status', 'progress')->orderBy('rab_no', 'asc')->get();

        return view('approved.create', compact('employees', 'rabs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'payreq_num' => 'required|unique:payreqs',
            'payreq_idr' => 'required',
        ]);

        if ($request->approve_date) {
            $approve_date = $request->approve_date;
        } else {
            $approve_date = date('Y-m-d');
        }

        $payreq = new Payreq();
        $payreq->user_id = $request->employee_id;
        $payreq->payreq_num = $request->payreq_num;
        $payreq->approve_date = $approve_date;
        $payreq->payreq_type = $request->payreq_type;
        $payreq->que_group = $request->que_group;
        $payreq->payreq_idr = $request->payreq_idr;
        $request->rab_id ? $payreq->rab_id = $request->rab_id : $payreq->rab_id = null;
        $payreq->remarks = $request->remarks;
        $payreq->created_by = auth()->user()->username;
        $payreq->save();

        return redirect()->route('approved.index')->with('success', 'Payment Request created');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $payreq = Payreq::findOrFail($id);
        $employees = User::orderBy('name', 'asc')->get();
        $rabs = Rab::where('status', 'progress')->orderBy('rab_no', 'asc')->get();

        return view('approved.edit', compact('payreq', 'employees', 'rabs'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'payreq_num' => 'required|unique:users,username,' . $id,
            'approve_date' => 'required',
            'payreq_type' => 'required',
            'payreq_idr' => 'required',
        ]);

        $payreq = Payreq::findOrFail($id);
        $payreq->user_id = $request->employee_id;
        $payreq->payreq_num = $request->payreq_num;
        $payreq->approve_date = $request->approve_date;
        $payreq->payreq_type = $request->payreq_type;
        $payreq->que_group = $request->que_group;
        $payreq->payreq_idr = $request->payreq_idr;
        $payreq->remarks = $request->remarks;
        $request->rab_id ? $payreq->rab_id = $request->rab_id : $payreq->rab_id = null;
        $payreq->updated_by = auth()->user()->username;
        $payreq->save();

        return redirect()->route('approved.index')->with('success', 'Payment Request updated');
    }

    public function destroy($id)
    {
        $payreq = Payreq::findOrFail($id);
        $payreq->delete();

        return redirect()->route('approved.index')->with('success', 'Payment Request deleted');
    }

    public function data()
    {
        $payreqs = Payreq::select('id', 'payreq_num', 'user_id', 'approve_date', 'payreq_type', 'payreq_idr', 'outgoing_date', 'rab_id')
            ->selectRaw('datediff(now(), approve_date) as days')
            ->whereNull('outgoing_date')
            ->orderBy('approve_date', 'desc')
            ->get();

        return datatables()->of($payreqs)
            ->editColumn('payreq_num', function ($payreq) {
                if ($payreq->rab_id) {
                    return $payreq->payreq_num . ' ' . '<i class="fas fa-check"></i>';
                }
                return $payreq->payreq_num;
            })
            ->editColumn('approve_date', function ($payreq) {
                return date('d-m-Y', strtotime($payreq->approve_date));
            })
            ->editColumn('payreq_idr', function ($payreq) {
                return number_format($payreq->payreq_idr, 0);
            })
            ->addColumn('employee', function ($payreq) {
                return $payreq->employee->name;
            })
            ->addIndexColumn()
            ->addColumn('action', 'approved.action')
            ->rawColumns(['action', 'payreq_num'])
            ->toJson();
    }
}
