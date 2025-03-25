<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\SystemVariable;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    //
    public function index()
    {
        $payments = Payment::all();
        return view('payments.index', [
            'title' => 'Payments',
            'payments' => $payments
        ]);
    }

    public function create()
    {
        return view('payments.create', [
            'title' => 'Record Payment'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'invoice_id' => 'required|exists:invoices,invoice_id',
                'amount_paid' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method' => 'required|in:cash,cheque,bank transfer,credit card,debit card,deferred,mobile money',
                'payment_reference' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $invoice = Invoice::where('invoice_id', $request->invoice_id)->firstOrFail();
            $amountPaid = $request->amount_paid;

            // Create a new payment
            $payment = Payment::create([
                'invoice_id' => $invoice->invoice_id,
                'amount_paid' => $amountPaid,
                'payment_date' => $request->payment_date,
                'currency' => $invoice->currency,
                'payment_method' => $request->payment_method,
                'payment_reference' => Str::random(5),
                'notes' => $request->notes,
                'status' => 'uploaded',
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);

            // Update the invoice
            $invoice->amount_paid += $amountPaid;
            $invoice->balance = $invoice->total_amount - $invoice->amount_paid;

            if ($invoice->balance <= 0) {
                $invoice->status = 'Paid';
                $invoice->balance = 0;
            } elseif ($invoice->amount_paid > 0 && $invoice->amount_paid < $invoice->total_amount) {
                $invoice->status = 'Partially-Paid';
            }

            $invoice->save();

            DB::commit();

            return redirect()->route('payments.details', $payment->id)
                ->with('msg', 'Payment processed successfully.')
                ->with('flag', 'success');
        } catch (Exception $exception) {

            DB::rollBack();

            return back()->with('msg', $exception->getMessage())
                ->with('flag', 'danger');
        }
    }

    public function details($id)
    {
        $payment = Payment::findOrFail($id);
        $systemName = SystemVariable::where('type', 'name')->first();
        $systemEmail = SystemVariable::where('type', 'email')->first();
        $systemAddress = SystemVariable::where('type', 'address')->first();
        $systemPhone = SystemVariable::where('type', 'phone')->first();
        return view('payments.details', [
            'payment' => $payment,
            'title' => 'Payment Details',
            'systemName' => $systemName->value,
            'systemEmail' => $systemEmail->value,
            'systemAddress' => $systemAddress->value,
            'systemPhone' => $systemPhone->value,
        ]);
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments.edit', [
            'title' => 'Edit Payment',
            'payment' => $payment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'invoice_id' => 'required|exists:invoices,invoice_id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,cheque,bank transfer,credit card,debit card,deferred,mobile money',
            'payment_reference' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:uploaded,hold,pending,approved,rejected',
        ]);

        $validatedData['updated_by'] = Auth::user()->name;

        $payment = Payment::findOrFail($id);
        $payment->update($validatedData);

        return redirect()->route('payments.index')
            ->with('msg', 'Payment updated successfully.')
            ->with('flag', 'success');
    }

    public function downloadReceipt($id)
    {
        $payment = Payment::findOrFail($id);
        $systemName = SystemVariable::where('type', 'name')->first();
        $systemEmail = SystemVariable::where('type', 'email')->first();
        $systemAddress = SystemVariable::where('type', 'address')->first();
        $systemPhone = SystemVariable::where('type', 'phone')->first();
        $pdf = Pdf::loadView('payments.receipt', [
            'payment' => $payment,
            'systemName' => $systemName->value,
            'systemEmail' => $systemEmail->value,
            'systemAddress' => $systemAddress->value,
            'systemPhone' => $systemPhone->value,
        ]);

        return $pdf->download('receipt_' . $payment->id . '.pdf');
    }

    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'to_email' => 'required|email',
            'cc_email' => 'nullable|email',
            'bcc_email' => 'nullable|email',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        $payment = Payment::findOrFail($id);
        $systemName = SystemVariable::where('type', 'name')->first();
        $systemEmail = SystemVariable::where('type', 'email')->first();
        $systemAddress = SystemVariable::where('type', 'address')->first();
        $systemPhone = SystemVariable::where('type', 'phone')->first();
        $pdf = Pdf::loadView('payments.receipt', [
            'payment' => $payment,
            'systemName' => $systemName->value,
            'systemEmail' => $systemEmail->value,
            'systemAddress' => $systemAddress->value,
            'systemPhone' => $systemPhone->value,
        ]);

        Mail::send([], [], function ($message) use ($request, $payment, $pdf) {
            $message->to($request->to_email);

            if ($request->filled('cc_email')) {
                $message->cc($request->cc_email);
            }

            if ($request->filled('bcc_email')) {
                $message->bcc($request->bcc_email);
            }

            $message->subject($request->subject)
                ->html($request->body)
                ->attachData($pdf->output(), 'receipt_' . $payment->id . '.pdf');
        });

        return redirect()->route('payments.details', $payment->id)
            ->with('msg', 'Receipt sent successfully')
            ->with('flag', 'success');
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = $request->input('status');
        $payment->save();

        return redirect()->route('payments.index')->with('success', 'Payment status updated successfully.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index')
            ->with('msg', 'Payment deleted successfully.')
            ->with('flag', 'success');
    }
}
