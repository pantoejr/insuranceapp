<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm mb-4 border-0" style="min-height: 450px;">
            <div class="card-header">
                @include('insurers.partials.add_or_edit_user')
                <div class="card-title" id="user-header" style="cursor: pointer;">Insurer User</div>
                <div class="card-tools">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInsurerUserModal"><i
                            class="bi bi-plus-circle"></i></button>
                </div>
            </div>
            <div class="card-body" id="user-body">
                <div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Insurer</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model->assignments as $assignment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $assignment->insurer->company_name }}</td>
                                    <td>{{ $assignment->name }}</td>
                                    <td>{{ $assignment->email }}</td>
                                    <td>{{ $assignment->phone }}</td>
                                    <td>
                                        <button class="btn btn-warning  btn-sm edit-btn" data-bs-toggle="modal"
                                            data-bs-target="#editInsurerUserModal"
                                            data-insurerAssignment-id={{ $assignment->id }}><i
                                                class="bi bi-pencil-fill"></i></button>
                                        <form
                                            action="{{ route('insurer-assignments.destroy', ['insurer' => $model, 'insurerAssignment' => $assignment]) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
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
    </div>
</div>
