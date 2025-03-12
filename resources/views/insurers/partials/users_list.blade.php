<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header">
                <div class="card-title" id="user-header" style="cursor: pointer;">Insurer User</div>
                <div class="card-tools">
                    <a href="{{ route('insurer-assignments.create') }}" class="btn btn-primary">Add Insurer
                        User</a>
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
                                        <a href="{{ route('insurer_assignments.details', $assignment->id) }}"
                                            class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('insurer_assignments.edit', $assignment->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('insurer_assignments.destroy', $assignment->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this assignment?')">Delete</button>
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
