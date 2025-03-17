<div class="row mb-3">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <div class="card-title" id="employee-header" style="cursor: pointer;">{{ $model->full_name }} Employees
                </div>
                <div class="card-tools">
                    <a href="{{ route('employees.create', ['client' => $model]) }}" class="btn btn-primary"><i
                            class="bi bi-plus-circle"></i></a>
                </div>
            </div>
            <div class="card-body table-responsive" id="employee-body">
                <div class="table-responsive">
                    <table class="table table-striped dataTable nowrap">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Gender</td>
                                <td>Position</td>
                                <td>Email</td>
                                <td>Action(s)</td>
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
                                        <a href="{{ route('employees.edit', ['employee' => $employee->id, 'client' => $model]) }}"
                                            class="btn btn-warning btn-sm"> <i class="bi bi-pencil-fill"></i></a>
                                        <a href="{{ route('employees.details', ['employee' => $employee->id, 'client' => $model]) }}"
                                            class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                        <form
                                            action="{{ route('employees.destroy', ['employee' => $employee->id, 'client' => $model]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this employee?');"><i
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
