<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

    public function edit(Client $client, $id)
    {
        $clientService = ClientService::findOrFail($id);
        return view('client_service.edit', [
            'title' => 'Edit Client Service',
            'clientService' => $clientService,
        ]);
    }

    public function update(Client $client, Request $request, $id) {}
}
