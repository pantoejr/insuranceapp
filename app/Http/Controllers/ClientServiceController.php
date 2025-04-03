<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $clientServices = ClientService::with(['service', 'client'])->get();
        return view('client_services.index', [
            'title' => 'Client Services',
            'clientServices' => $clientServices,
        ]);
    }

    public function create()
    {
        return view('client_services.create', [
            'title' => 'Assign Service to Client',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_id' => 'required|exists:clients,id',
            'cost' => 'required|numeric|min:0.01',
            'currency' => 'required|in:usd,lrd',
            'is_discounted' => 'boolean',
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'service_duration_start' => 'nullable|date',
            'service_duration_end' => 'nullable|date|after_or_equal:service_duration_start',
            'payment_method' => 'required|in:cash,cheque,bank transfer,credit card,debit card,deferred,mobile money',
            'status' => 'required|in:Pending,Processing,Completed,Rejected',
        ]);

        try {
            DB::beginTransaction();
            $validatedData['created_by'] = Auth::user()->name;
            $validatedData['updated_by'] = Auth::user()->name;
            ClientService::create($validatedData);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }

        return redirect()->route('client_services.index')
            ->with('msg', 'Service assigned to client successfully')
            ->with('flag', 'success');
    }

    public function edit($id)
    {
        $clientService = ClientService::findOrFail($id);
        return view('client_services.edit', [
            'title' => 'Edit Client Service',
            'clientService' => $clientService,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_id' => 'required|exists:clients,id',
            'cost' => 'required|numeric|min:0.01',
            'currency' => 'required|in:usd,lrd',
            'is_discounted' => 'boolean',
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'service_duration_start' => 'nullable|date',
            'service_duration_end' => 'nullable|date|after_or_equal:service_duration_start',
            'payment_method' => 'required|in:cash,cheque,bank transfer,credit card,debit card,deferred,mobile money',
            'status' => 'required|in:Pending,Processing,Completed,Rejected',
        ]);

        try {
            DB::beginTransaction();
            $clientService = ClientService::findOrFail($id);
            $validatedData['updated_by'] = Auth::user()->name;
            $clientService->update($validatedData);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }

        return redirect()->route('client_services.index')
            ->with('msg', 'Client service updated successfully')
            ->with('flag', 'success');
    }

    public function destroy($id)
    {
        $clientService = ClientService::findOrFail($id);
        $clientService->delete();
        return redirect()->route('client_services.index')
            ->with('msg', 'Client service deleted successfully')
            ->with('flag', 'success');
    }
}
