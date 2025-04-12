<?php

namespace App\Http\Controllers;

use App\Helpers\SmsHelper;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClientServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create(Client $client)
    {
        $services = Service::all();
        return view('client_service.create', [
            'title' => 'Create Client Service',
            'client' => $client,
            'services' => $services,
        ]);
    }

    public function store(Request $request, Client $client)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'service_id' => 'required|exists:services,id',
                'client_id' => 'required|exists:clients,id',
                'cost' => 'required|numeric|min:0.01',
                'currency' => 'required|in:usd,lrd',
                'is_discounted' => 'nullable|boolean',
                'discount' => 'nullable|numeric|min:0.01',
                'notes' => 'nullable|string',
                'service_duration_start' => 'nullable|date',
                'service_duration_end' => 'nullable|date|after:service_duration_start',
                'payment_method' => 'required|in:cash,cheque,bank transfer,credit card,debit card,deferred,mobile money',
                'service_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $validatedData['is_discounted'] = $request->has('is_discounted') ? $request->is_discounted : 0;
            $validatedData['discount'] = $validatedData['is_discounted'] ? $request->input('discount', 0) : 0;
            $validatedData['status'] = 'Pending';
            $validatedData['created_by'] = Auth::user()->name;
            $validatedData['updated_by'] = Auth::user()->name;

            $clientService = ClientService::create($validatedData);

            if ($request->hasFile('service_document')) {
                foreach ($request->file('service_document') as $file) {
                    $clientService->attachments()->create([
                        'attachmentable_type' => ClientService::class,
                        'attachmentable_id' => $clientService->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_path' => $file->store('attachments', 'public'),
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                }
            }
        } catch (\Exception $ex) {
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }

        return redirect()->route('clients.details', $client->id)
            ->with('msg', 'Client Service created successfully')
            ->with('flag', 'success');
    }

    public function edit(Client $client, $id)
    {
        $clientService = ClientService::find($id);
        return view('client_service.edit', [
            'title' => 'Edit Client Service',
            'clientService' => $clientService,
            'client' => $client,
            'services' => Service::all(),
        ]);
    }

    public function update(Client $client, Request $request, $id)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_id' => 'required|exists:clients,id',
            'cost' => 'required|numeric|min:0.01',
            'currency' => 'required|in:usd,lrd',
            'is_discounted' => 'nullable|boolean',
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount' => 'nullable|numeric|min:0.01',
            'notes' => 'nullable|string',
            'service_duration_start' => 'nullable|date',
            'service_duration_end' => 'nullable|date|after:service_duration_start',
            'payment_method' => 'required|in:cash,cheque,bank transfer,credit card,debit card,deferred,mobile money',
        ]);

        $validatedData['is_discounted'] = $request->has('is_discounted') ? $request->is_discounted : 0;
        $validatedData['updated_by'] = Auth::user()->name;

        try {
            $clientService = ClientService::find($id);
            $clientService->update($validatedData);
        } catch (\Exception $ex) {
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
        return redirect()->route('clients.details', $client->id)
            ->with('msg', 'Client Service updated successfully')
            ->with('flag', 'success');
    }

    public function details(Client $client, $id)
    {
        $clientService = ClientService::find($id);
        return view('client_service.details', [
            'title' => 'Client Service Details',
            'client' => $client,
            'clientService' => $clientService,
        ]);
    }

    public function destroy(Client $client, $id)
    {
        try {
            $clientService = ClientService::find($id);
            $clientService->delete();
        } catch (\Exception $ex) {
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
        return redirect()->route('clients.details', $client->id)
            ->with('msg', 'Client Service deleted successfully')
            ->with('flag', 'success');
    }

    public function updateStatus(Client $client, Request $request, $id)
    {
        $clientService = ClientService::findOrFail($id);

        if ($clientService->status !== 'Pending') {
            return redirect()->back()->with('error', 'Status cannot be updated unless it is Pending.');
        }

        $newStatus = $request->input('status');
        $clientService->status = $newStatus;
        $clientService->save();

        if ($newStatus === 'Completed') {
            $client = $clientService->client;
            $serviceName = $clientService->service->name;

            SmsHelper::sendSms($client->phone, 'Your service request for ' . $serviceName . ' has been completed.');
            Mail::send('emails.service_completed', ['client' => $client, 'serviceName' => $serviceName], function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('Service Request Completed');
            });
        }

        return redirect()->route('clients.details', ['id' => $client->id])->with('success', 'Status updated successfully.');
    }
}
