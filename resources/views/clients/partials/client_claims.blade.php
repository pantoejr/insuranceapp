<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="card-title">
            {{ $model->full_name }} Claims
        </div>
        <div class="card-tools">
            <a href="{{ route('claims.create', ['client' => $model]) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
            </a>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped dataTable nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Policy</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model->claims as $claim)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $claim->policy->name }}</td>
                            <td>{{ $claim->amount }}</td>
                            <td>{{ ucfirst($claim->status) }}</td>
                            <td>

                                <a href="{{ route('claims.edit', ['client' => $model->id, 'id' => $claim->id]) }}"
                                    class="btn btn-warning btn-sm edit-btn">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="{{ route('claims.details', ['client' => $model->id, 'id' => $claim->id]) }}"
                                    class="btn btn-primary btn-sm view-btn">
                                    <i class="bi bi-journal-text"></i>
                                </a>

                                <form action="{{ route('claims.destroy', ['client' => $model, 'id' => $claim->id]) }}"
                                    style="display: inline-block" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
