<?php

namespace App\Http\Controllers;

use App\Models\Payreq;
use App\Models\Rab;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function display(Request $request)
    {
        $payreq = Payreq::where('payreq_num', $request->payreq_no)->first();

        return view('search.display', compact('payreq'));
    }

    public function edit($id)
    {
        $payreq = Payreq::find($id);
        $employees = User::orderBy('name', 'asc')->get();
        $rabs = Rab::where('status', 'progress')->orderBy('rab_no', 'asc')->get();

        return view('search.edit', compact('payreq', 'employees', 'rabs'));
    }

    public function update(Request $request, $id)
    {
        return $request->all();
        die;
        $this->validate($request, [
            'employee_id' => 'required',
            // 'payreq_num' => 'required|unique:payreqs,payreq_num,' . $id,
            'approve_date' => 'required',
            'payreq_type' => 'required',
            'payreq_idr' => 'required',
        ]);

        $payreq = Payreq::findOrFail($id);
        $payreq->user_id = $request->user_id;
        $payreq->payreq_num = $request->payreq_num;
        $payreq->approve_date = $request->approve_date;
        $payreq->payreq_type = $request->payreq_type;
        $payreq->que_group = $request->que_group;
        $payreq->payreq_idr = $request->payreq_idr;
        $payreq->outgoing_date = $request->outgoing_date;
        $payreq->realization_date = $request->realization_date;
        $payreq->realization_num = $request->realization_num;
        $payreq->realization_amount = $request->realization_amount;
        $payreq->rab_id = $request->rab_id;
        $payreq->remarks = $request->remarks;

        $payreq->save();


        return redirect()->route('search.index')->with('success', 'Payment Request updated');
    }

    public function destroy($id)
    {
        $payreq = Payreq::findOrFail($id);
        $payreq->delete();

        return redirect()->route('search.index')->with('success', 'Payment Request deleted');
    }
}
