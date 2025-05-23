@can('view-employees')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title" id="employee-header" style="cursor: pointer;">{{ $model->full_name }} Employees
                    </div>
                    <div class="card-tools">
                        @can('add-employee')
                            <a href="{{ route('employees.create', ['client' => $model]) }}" class="btn btn-primary"><i
                                    class="bi bi-plus-circle"></i></a>
                        @endcan
                    </div>
                </div>
                <div class="card-body table-responsive" id="employee-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Email</th>
                                    <th>Action(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model->employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->employee_name }}</td>
                                        <td>{{ ucfirst($employee->gender) }}</td>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            @can('edit-employee')
                                                <a href="{{ route('employees.edit', ['employee' => $employee->id, 'client' => $model]) }}"
                                                    class="btn btn-warning btn-sm"> <i class="bi bi-pencil-fill"></i></a>
                                            @endcan
                                            @can('view-employee-details')
                                                <a href="{{ route('employees.details', ['employee' => $employee->id, 'client' => $model]) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                            @endcan
                                            @can('delete-employee')
                                                <form
                                                    action="{{ route('employees.destroy', ['employee' => $employee->id, 'client' => $model]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn"><i
                                                            class="bi bi-trash"></i></button>
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
