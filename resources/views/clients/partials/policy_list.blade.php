@can('view-client-policies')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title" id="policy-header" style="cursor: pointer;">{{ $model->full_name }} Policies</div>
                    <div class="card-tools">
                        @can('add-client-policy')
                            <a href="{{ route('client-policies.create', ['client' => $model]) }}" class="btn btn-primary"><i
                                    class="bi bi-plus-circle"></i></a>
                        @endcan
                    </div>
                </div>
                <div class="card-body" id="policy-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Policy</th>
                                    <th>Insurer</th>
                                    <th>Assigned By</th>
                                    <th>Status</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model->policyAssignments as $clientPolicy)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $clientPolicy->policy->policyType->name }}</td>
                                        <td>{{ $clientPolicy->insurer->company_name }}</td>
                                        <td>{{ $clientPolicy->created_by }}</td>
                                        <td>
                                            @if ($clientPolicy->status === 'draft')
                                                <span
                                                    class="badge bg-primary">{{ strtoupper($clientPolicy->status) }}</span>
                                            @elseif($clientPolicy->status === 'submitted')
                                                <span class="badge bg-info">{{ strtoupper($clientPolicy->status) }}</span>
                                            @elseif ($clientPolicy->status === 'pending')
                                                <span
                                                    class="badge bg-warning">{{ strtoupper($clientPolicy->status) }}</span>
                                            @elseif ($clientPolicy->status === 'approved')
                                                <span
                                                    class="badge bg-success">{{ strtoupper($clientPolicy->status) }}</span>
                                            @elseif ($clientPolicy->status === 'completed')
                                                <span
                                                    class="badge bg-success">{{ strtoupper($clientPolicy->status) }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @can('edit-client-policy')
                                                @if ($clientPolicy->status === 'draft')
                                                    <a href="{{ route('client-policies.edit', ['client' => $model, 'id' => $clientPolicy->id]) }}"
                                                        class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                                @endif
                                            @endcan
                                            @can('view-client-policy-details')
                                                <a href="{{ route('client-policies.details', ['client' => $model, 'id' => $clientPolicy->id]) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-journal-text"></i></a>
                                            @endcan
                                            @can('delete-client-policy')
                                                <form
                                                    action="{{ route('client-policies.destroy', ['client' => $model, 'id' => $clientPolicy->id]) }}"
                                                    method="POST" style="display:inline;">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="bi bi-trash"></i></button>
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
        </div>
    </div>

@endcan
