<div class="modal" id="viewPolicyModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Insurer Policy Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="form-group mb-3">
                        <label for="view_insurer" class="form-label">Insurer</label>
                        <input type="text" id="view_insurer" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="view_policy" class="form-label">Policy</label>
                        <input type="text" class="form-control" id="view_policy" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="view_status" class="form-label">Status</label>
                        <input type="text" id="view_status" class="form-control" readonly>
                    </div>

                    <div class="form-group">
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
        $('.view-policy-btn').on('click', function() {
            var policyId = $(this).data('id');
            loadPolicyData(policyId);
        });

        function loadPolicyData(id) {
            $.ajax({
                url: '/insurer-policies/details/' + id,
                type: 'GET',
                success: function(response) {
                    $('#view_policy').val(response.policy_type_name);
                    $('#view_insurer').val(response.insurer_name).trigger('change');
                    $('#view_status').val(response.status);
                    $('#viewPolicyModal').modal('show');
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
    });
</script>
