<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\SystemVariable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', [
            'title' => 'Invoices',
            'invoices' => $invoices,
        ]);
    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.edit', [
            'title' => 'Edit Invoice',
            'invoice' => $invoice,
        ]);
    }

    public function details($id)
    {
        $systemName = SystemVariable::where('type', 'name')->first();
        $systemEmail = SystemVariable::where('type', 'email')->first();
        $systemAddress = SystemVariable::where('type', 'address')->first();
        $systemPhone = SystemVariable::where('type', 'phone')->first();

        $invoice = Invoice::with([
            'invoiceable' => function ($query) {
                $query->with(['client']);

                $model = $query->getModel();

                if ($model instanceof \App\Models\Policy) {
                    $query->with('policy');
                }

                if ($model instanceof \App\Models\ClientService) {
                    $query->with('clientService.service');
                }
            }
        ])->where('invoice_id', $id)->first();

        return view('invoices.details', [
            'title' => 'Invoice Details',
            'invoice' => $invoice,
            'systemName' => $systemName,
            'systemAddress' => $systemAddress,
            'systemEmail' => $systemEmail,
            'systemPhone' => $systemPhone,
        ]);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->update($request->only('amount', 'due_date', 'status'));

        return redirect()->route('invoices.index')->with('msg', 'Invoice updated successfully.')
            ->with('flag', 'success');
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('msg', 'Invoice deleted successfully.')
            ->with('flag', 'success');
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        $systemName = SystemVariable::where('type', 'name')->first();
        $systemEmail = SystemVariable::where('type', 'email')->first();
        $systemAddress = SystemVariable::where('type', 'address')->first();
        $systemPhone = SystemVariable::where('type', 'phone')->first();
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'systemName' => $systemName->value,
            'systemAddress' => $systemAddress->value,
            'systemEmail' => $systemEmail->value,
            'systemPhone' => $systemPhone->value,
        ]);
        return $pdf->download('invoice_' . $invoice->invoice_id . '.pdf');
    }

    public function sendEmail($id)
    {
        $invoice = Invoice::findOrFail($id);
        $systemName = SystemVariable::where('type', 'name')->first();
        $systemEmail = SystemVariable::where('type', 'email')->first();
        $systemAddress = SystemVariable::where('type', 'address')->first();
        $systemPhone = SystemVariable::where('type', 'phone')->first();
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'systemName' => $systemName->value,
            'systemAddress' => $systemAddress->value,
            'systemEmail' => $systemEmail->value,
            'systemPhone' => $systemPhone->value,
        ]);

        Mail::send('emails.invoice', compact('invoice'), function ($message) use ($invoice, $pdf) {
            $message->to($invoice->client->email)
                ->subject('Invoice ' . $invoice->invoice_id)
                ->attachData($pdf->output(), 'invoice_' . $invoice->invoice_id . '.pdf');
        });

        return redirect()->route('invoices.details', ['id' => $invoice->id])
            ->with('msg', 'Invoice sent successfully')
            ->with('flag', 'success');
    }

    public function updateStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->status = $request->input('status');
        $invoice->notes = $request->input('notes');
        $invoice->save();

        return redirect()->route('invoices.show', $invoice->id)
            ->with('msg', 'Invoice status updated successfully')
            ->with('flag', 'success');
    }

    public function checkInvoice($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);
        return response()->json($invoice);
    }
}
