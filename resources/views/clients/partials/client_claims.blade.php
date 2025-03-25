<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="card-title">
            {{ $model->full_name }} Claims
        </div>
        <div class="card-tools">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClaimModal">
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
                                <form action="{{ route('claims.destroy', ['id' => $claim->id]) }}"
                                    style="display: inline-block">
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

<div class="modal modal-lg fade" id="createClaimModal" tabindex="-1" aria-labelledby="createClaimModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClaimModalLabel">Create Claim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createClaimForm" action="{{ route('claims.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $model->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="policy_id" class="form-label">Policy</label>
                                <select class="form-control @error('policy_id') is-invalid @enderror" id="policy_id"
                                    name="policy_id" required>
                                    @foreach ($model->policyAssignments as $policyAssignment)
                                        <option value="{{ $policyAssignment->policy->id }}">
                                            {{ $policyAssignment->policy->name }}</option>
                                    @endforeach
                                </select>
                                @error('policy_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-control @error('currency') is-invalid @enderror" id="currency"
                                    name="currency" required>
                                    <option value="0">Select Currency</option>
                                    <option value="usd">USD</option>
                                    <option value="lrd">LRD</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="claim_type" class="form-label">Claim Type</label>
                                <input type="text" class="form-control @error('claim_type') is-invalid @enderror"
                                    id="claim_type" name="claim_type" required>
                                @error('claim_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="claim_documents" class="form-label">Document(s)</label>
                                <input type="file" name="claim_documents" id="claim_documents" class="form-control"
                                    multiple>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" required></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Create</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#createClaimForm').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.flag === 'success') {
                        $('#createClaimModal').modal('hide');
                        Swal.fire({
                            title: "Success",
                            text: "Claims submitted successfully",
                            icon: "success",
                            draggable: true,
                        })
                        location.reload();
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.msg,
                            icon: "error",
                        })
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "An error occured while submitting the claim",
                        icon: "error",
                    });
                }
            });
        });
    });
</script>
