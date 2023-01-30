<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }

    public function paid_index()
    {
        return view('invoices.paid');
    }

    public function paid(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if ($request->payment_date) {
            $payment_date = $request->payment_date;
        } else {
            $payment_date = date('Y-m-d');
        }

        // update local db
        $invoice->payment_date = $payment_date;
        $invoice->save();

        // UPDATE ACCOUNT BALANCE
        $account = Account::find($request->account_id);
        $account->balance -= $invoice->amount;
        $account->save();

        // SAVE ACTIVITY
        $activityCtrl = app(ActivityController::class);
        $activityCtrl->store(auth()->user()->id, 'Payment Invoice ', $invoice->nomor_invoice);

        // // update remote db
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('POST', 'http://localhost:8000/api/invoices/paid', [
        //     'form_params' => [
        //         'id' => $invoice->id,
        //         'payment_date' => $payment_date,
        //     ]
        // ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice has been updated');
    }

    public function data()
    {
        $invoices = Invoice::whereNull('payment_date')->orderBy('received_date', 'desc')->get();

        return datatables()->of($invoices)
            ->editColumn('received_date', function ($invoices) {
                return $invoices->received_date ? date('d-M-Y', strtotime($invoices->received_date)) : '-';
            })
            ->editColumn('amount', function ($invoices) {
                return number_format($invoices->amount, 2);
            })
            ->addColumn('days', function ($invoices) {
                $received_date = new \DateTime($invoices->received_date);
                $today = new \DateTime(now());
                $diff_days = $received_date->diff($today)->format('%a');

                return $diff_days;
            })
            ->addIndexColumn()
            ->addColumn('action', 'invoices.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function paid_data()
    {
        $invoices = Invoice::whereNotNull('payment_date')->orderBy('payment_date', 'desc')->get();

        return datatables()->of($invoices)
            ->editColumn('received_date', function ($invoices) {
                return $invoices->received_date ? date('d-M-Y', strtotime($invoices->received_date)) : '-';
            })
            ->editColumn('payment_date', function ($invoices) {
                return $invoices->payment_date ? date('d-M-Y', strtotime($invoices->payment_date)) : '-';
            })
            ->editColumn('amount', function ($invoices) {
                return number_format($invoices->amount, 2);
            })
            // diff days
            ->addColumn('days', function ($invoices) {
                $received_date = new \DateTime($invoices->received_date);
                $payment_date = new \DateTime($invoices->payment_date);
                $diff_days = $received_date->diff($payment_date)->format('%a');

                return $diff_days;
            })
            ->addIndexColumn()
            ->toJson();
    }
}
