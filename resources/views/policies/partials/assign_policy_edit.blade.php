<div class="modal" id="editPolicyModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Edit Policy Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Insurer Policy</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Edit Policy Modal Body -->
            <div class="modal-body">
                <form id="editPolicyForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_policy_assignment_id" name="id">

                    <div class="form-group mb-3">
                        <label for="edit_insurer_id" class="form-label">Insurer</label>
                        <select class="form-control @error('insurer_id') is-invalid @enderror" id="edit_insurer_id"
                            name="insurer_id[]" required multiple>
                            @foreach ($insurers as $insurer)
                                <option value="{{ $insurer->id }}">
                                    {{ $insurer->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('insurer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_policy_id" class="form-label">Policy</label>
                        <select class="form-control @error('policy_id') is-invalid @enderror" id="edit_policy_id"
                            name="policy_id" required>
                            <option value="{{ $policy->id }}">
                                {{ $policy->policyType->name }}
                            </option>
                        </select>
                        @error('policy_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="edit_status"
                            name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <div id="edit_loading" class="spinner-border text-primary" role="status"
                            style="display: none;">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.edit-policy-btn').on('click', function() {
            var policyId = $(this).data('id');
            loadPolicyData(policyId);
        });

        function loadPolicyData(id) {
            $.ajax({
                url: '/insurer-policies/edit/' + id,
                type: 'GET',
                success: function(response) {
                    console.log(response);

                    $('#edit_policy_assignment_id').val(response.id);

                    $('#edit_insurer_id').val(response.insurer_ids).trigger('change');

                    $('#edit_policy_id').val(response.policy_id);

                    $('#edit_status').val(response.status);

                    $('#editPolicyModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error loading Insurer Policy',
                        icon: 'error'
                    });
                }
            });
        }

        // Edit form submission
        $('#editPolicyForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_policy_assignment_id').val();
            var formData = new FormData(this);
            $('#edit_loading').show();

            $.ajax({
                url: '/insurer-policies/edit/' + id,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    $('#edit_loading').hide();
                    if (response.flag === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: response.msg,
                            icon: 'success'
                        }).then(() => {
                            $('#editPolicyModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.msg,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    $('#edit_loading').hide();
                    if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#edit_' + key).addClass('is-invalid');
                            $('#edit_' + key).after(
                                '<div class="invalid-feedback">' + value[0] +
                                '</div>');
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while updating the policy.',
                            icon: 'error'
                        });
                    }
                }
            });
        });

        $('#editPolicyModal').on('hidden.bs.modal', function() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        });
    });
</script>
