<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header">
                @include('insurers.partials.add_or_edit_user')
                <div class="card-title" id="user-header" style="cursor: pointer;">Insurer User</div>
                <div class="card-tools">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInsurerUserModal"><i
                            class="bi bi-pencil-fill"></i></button>
                </div>
            </div>
            <div class="card-body" id="user-body" style="display: none;">
                <div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Insurer</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insurer->assignments as $assignment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $assignment->insurer->company_name }}</td>
                                    <td>{{ $assignment->user->name }}</td>
                                    <td>{{ ucfirst($assignment->status) }}</td>
                                    <td>
                                        <button class="btn btn-warning  btn-sm edit-btn" data-bs-toggle="modal"
                                            data-bs-target="#editInsurerUserModal"
                                            data-insurerAssignment-id={{ $assignment->id }}><i
                                                class="bi bi-pencil-fill"></i></button>
                                        <form
                                            action="{{ route('insurer-assignments.destroy', ['insurer' => $insurer, 'insurerAssignment' => $assignment]) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this assignment?')"><i
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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#user-header').click(function() {
            $('#user-body').toggle();
        });
    });
</script>
