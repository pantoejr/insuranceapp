<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm mb-4" style="border:none;">
            <div class="card-header" style="border:none;">
                <div class="card-title" id="policy-header" style="cursor: pointer;">Insurer Policies</div>
                <div class="card-tools">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#assignPoliciesModal">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </div>
                @include('insurers.partials.edit_policy')
            </div>
            <div class="card-body" id="policy-body" style="min-height: 400px;">
                <div class="table-responsive">
                    <table class="table dataTable nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Insurer</th>
                                <th>Policy</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model->insurerPolicies as $insurerPolicy)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $insurerPolicy->insurer->company_name }}</td>
                                    <td>{{ $insurerPolicy->policy->name }}</td>
                                    <td>{{ ucfirst($insurerPolicy->status) }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-policy-btn" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-insurer-id="{{ $model->id }}"
                                            data-insurerPolicy-id="{{ $insurerPolicy->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form
                                            action="{{ route('insurers.removeInsurerPolicy', ['id' => $insurerPolicy->id, 'insurerId' => $model->id]) }}"
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
<!-- Assign Policies Modal -->
<div class="modal fade" id="assignPoliciesModal" tabindex="-1" aria-labelledby="assignPoliciesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignPoliciesModalLabel">Assign Policies to Insurer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignPoliciesForm" action="{{ route('insurers.storeMultiplePolicies') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="insurer_id" class="form-label">Insurer</label>
                        <select class="form-control @error('insurer_id') is-invalid @enderror" id="insurer_id"
                            name="insurer_id" required>
                            <option value="{{ $model->id }}">{{ $model->company_name }}</option>
                        </select>
                        @error('insurer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="policy_ids" class="form-label">Policies</label>
                        <select class="form-control @error('policy_ids') is-invalid @enderror" id="policy_ids"
                            name="policy_ids[]" multiple required>
                            @foreach ($policies as $policy)
                                <option value="{{ $policy->id }}">{{ $policy->name }}</option>
                            @endforeach
                        </select>
                        @error('policy_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#assignPoliciesForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.flag === 'success') {
                        $('#assignPoliciesModal').modal('hide');
                        Swal.fire({
                            title: "Success",
                            text: "Policy assigned successfully",
                            icon: "success",
                            draggable: true,
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "An error occured while assigning the policies",
                            icon: "error",
                            draggable: true,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "An error occured while assigning the policies",
                        icon: "error",
                        draggable: true,
                    });
                }
            });
        });
    });
</script>
