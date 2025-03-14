<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Insurer Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPolicyForm">
                    @csrf
                    <input type="hidden" id="ePolicyId" name="insurance_policy_id">
                    <div class="form-group mb-3">
                        <label for="editPolicySelect">Policy</label>
                        <select id="editPolicySelect" name="policy_id" class="form-control">
                            @foreach ($policies as $policy)
                                <option value="{{ $policy->id }}">{{ $policy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editStatusSelect">Status</label>
                        <select id="editStatusSelect" name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.edit-policy-btn').on('click', function() {
            var insurerPolicyId = $(this).data('insurerpolicy-id');

            $.ajax({
                url: '/insurers/editPolicy/' + insurerPolicyId,
                method: 'GET',
                success: function(response) {
                    $('#ePolicyId').val(response.id);
                    $('#editPolicySelect').val(response.policy_id);
                    $('#editStatusSelect').val(response.status);
                },
                error: function(xhr) {
                    console.error('Error fetching policy data:', xhr.responseText);
                }
            });
        });

        $('#editPolicyForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            var policyId = $('#ePolicyId').val();

            $.ajax({
                url: '/insurers/editPolicy/' + policyId,
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Policy updated successfully!');
                    location.reload();
                },
                error: function(xhr) {
                    console.error('Error updating policy:', xhr.responseText);
                }
            });
        });
    });
</script>
