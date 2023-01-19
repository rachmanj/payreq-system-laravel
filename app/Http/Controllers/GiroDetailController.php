<?php

namespace App\Http\Controllers;

use App\Models\Giro;
use App\Models\GiroDetail;
use Illuminate\Http\Request;

class GiroDetailController extends Controller
{
    public function index($giro_id)
    {
        $giro = Giro::find($giro_id);
        $giro_details = GiroDetail::where('giro_id', $giro_id)->get();
        $amount = $giro_details->sum('amount');

        return view('giros.details.index', compact('giro', 'giro_details', 'amount'));
    }

    public function store(Request $request, $giro_id)
    {
        $request->validate([
            'remarks' => 'required',
            'amount' => 'required',
        ]);

        GiroDetail::create([
            'giro_id' => $giro_id,
            'remarks' => $request->remarks,
            'amount' => $request->amount,
            'is_cashin' => $request->is_cashin,
        ]);

        $giro = Giro::find($giro_id);

        // SAVE ACTIVITY
        $activityCtrl = app(ActivityController::class);
        $activityCtrl->store(auth()->user()->id, 'Detail Giro', $giro->nomor);

        return redirect()->route('giros.detail.index', $giro_id);
    }

    public function destroy($id)
    {
        $giro_detail = GiroDetail::find($id);
        $giro_id = $giro_detail->giro_id;
        $giro_detail->delete();

        return redirect()->route('giros.detail.index', $giro_id)->with('success', 'Data berhasil dihapus');
    }

    public function data($giro_id)
    {
        $giro_details = GiroDetail::where('giro_id', $giro_id)->get();

        return datatables()->of($giro_details)
            ->editColumn('amount', function ($giro_details) {
                return number_format($giro_details->amount, 0, ',', '.');
            })
            ->editColumn('is_cashin', function ($giro_details) {
                return $giro_details->is_cashin ? '<span class="right badge badge-primary">Yes</span>' : '<span class="right badge badge-info">No</span>';
            })
            ->addIndexColumn()
            ->addColumn('action', 'giros.details.action')
            ->rawColumns(['action', 'is_cashin'])
            ->make(true);
    }
}
