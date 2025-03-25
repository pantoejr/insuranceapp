<div class="row mb-3">
    <div class="col-md-12">
        <div class="card shadow-sm mb-4" style="border:none;">
            <div class="card-header" style="border:none;">
                <div class="card-title" id="dependent-header" style="cursor: pointer;">{{ $employee->employee_name }}
                    Dependents</div>
                <div class="card-tools">
                    <a href="{{ route('dependents.create', ['employee' => $employee->id]) }}" class="btn btn-primary"><i
                            class="bi bi-plus-circle"></i></a>
                </div>
            </div>
            <div class="card-body" id="dependent-body" style="display:none;">
                <div class="table-responsive">
                    <table class="table dataTable nowrap">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Relationship</td>
                                <td>Date of Birth</td>
                                <td>Action(s)</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->dependents as $dependent)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dependent->dependent_name }}</td>
                                    <td>{{ $dependent->relationship }}</td>
                                    <td>{{ $dependent->date_of_birth }}</td>
                                    <td>
                                        <a href="{{ route('dependents.edit', ['employee' => $employee->id, 'dependent' => $dependent->id]) }}"
                                            class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                        <a href="{{ route('dependents.details', ['employee' => $employee->id, 'dependent' => $dependent->id]) }}"
                                            class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                        <form
                                            action="{{ route('dependents.destroy', ['employee' => $employee->id, 'dependent' => $dependent->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
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
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dependent-header').click(function() {
            $('#dependent-body').toggle();
        });
    });
</script>
