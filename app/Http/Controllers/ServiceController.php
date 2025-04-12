<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $services = Service::all();
        return view('services.index', [
            'title' => 'Services',
            'services' => $services,
        ]);
    }

    public function create()
    {
        return view('services.create', [
            'title' => 'Create Service',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'terms_conditions' => 'required|string',
            'eligibility' => 'required|in:individual,company,both',
            'cost' => 'required|numeric|min:0.01',
            'currency' => 'required|in:usd,lrd',
            'frequency' => 'required|in:monthly,quartely,half-yearly,yearly,bi-yearly,tri-yearly,four-yearly,five-yearly',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();
            $validatedData['created_by'] = Auth::user()->name;
            $validatedData['updated_by'] = Auth::user()->name;
            $service = Service::create($validatedData);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return back()->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
        return redirect()->route('services.index')
            ->with('msg', 'Service created successfully')
            ->with('flag', 'success');
    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('services.edit', [
            'title' => 'Edit Service',
            'service' => $service,
        ]);
    }

    public function getServiceDetails($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }
}
