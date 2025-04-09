<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="card-title">Client Services</div>
        <div class="card-tools">
            <a href="{{ route('client-services.create', ['client' => $model]) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
            </a>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model->clientServices as $clientService)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $clientService->service->name }}</td>
                            <td>{{ $clientService->cost }}</td>
                            <td>{{ $clientService->currency }}</td>
                            <td class="text-end">
                                <a href="{{ route('client-services.edit', ['client' => $model, 'id' => $clientService->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form
                                    action="{{ route('client-services.destroy', ['client' => $model, 'id' => $clientService->id]) }}"
                                    method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
