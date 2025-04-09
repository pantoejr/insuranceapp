<div class="modal" id="addPolicyModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Add Policy Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Insurer Policy</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Add Policy Modal Modal Body -->
            <div class="modal-body">
                <form id="addPolicyForm" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="insurer_id" class="form-label">Insurer</label>
                        <select class="form-control @error('insurer_id') is-invalid @enderror" id="insurer_id"
                            name="insurer_id[]" required multiple>
                            @foreach ($insurers as $insurer)
                                <option value="{{ $insurer->id }}"
                                    {{ old('insurer_id') == $insurer->id ? 'selected' : '' }}>
                                    {{ $insurer->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('insurer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="policy_id" class="form-label">Policy</label>
                        <select class="form-control @error('policy_id') is-invalid @enderror" id="policy_id"
                            name="policy_id" required>
                            <option value="{{ $policy->id }}" {{ old('policy_id') == $policy->id ? 'selected' : '' }}>
                                {{ $policy->policyType->name }}
                            </option>
                        </select>
                        @error('policy_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <div id="loading" class="spinner-border text-primary" role="status" style="display: none;">
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
        $('#addPolicyForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();

            $.ajax({
                url: '{{ route('insurer-policies.store') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loading').hide();
                    if (response.flag === 'success') {
                        alert(response.msg);
                        location.reload();
                    } else {
                        alert(response.msg);
                    }
                },
                error: function(response) {
                    $('#loading').hide();
                    alert('An error occurred while adding the policy.' + response.msg);
                }
            });
        });
    });
</script>
