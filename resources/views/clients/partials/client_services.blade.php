@can('view-client-service')
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <div class="card-title">Client Services</div>
            <div class="card-tools">
                @can('add-client-service')
                    <a href="{{ route('client-services.create', ['client' => $model]) }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dataTable nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Cost</th>
                            <th>Currency</th>
                            <th>Action(s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($model->clientServices as $clientService)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $clientService->service->name }}</td>
                                <td>{{ $clientService->cost }}</td>
                                <td>{{ strtoupper($clientService->currency) }}</td>
                                <td>
                                    @can('edit-client-service')
                                        <a href="{{ route('client-services.edit', ['client' => $model, 'id' => $clientService->id]) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan
                                    @can('view-client-service')
                                        <a href="{{ route('client-services.details', ['client' => $model, 'id' => $clientService->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-journal-text"></i>
                                        </a>
                                    @endcan
                                    @can('delete-client-service')
                                        <form
                                            action="{{ route('client-services.destroy', ['client' => $model, 'id' => $clientService->id]) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endcan
