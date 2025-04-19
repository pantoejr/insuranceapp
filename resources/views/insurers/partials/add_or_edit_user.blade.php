{{-- Add Insurer User Modal --}}
<div class="modal fade" id="addInsurerUserModal" tabindex="-1" aria-labelledby="addInsurerUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInsurerUserLabel">Add Insurer User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addInsurerUserForm">
                    @csrf
                    <input type="hidden" id="insurerId" name="insurer_id" value="{{ $model->id }}">

        
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required />
                    </div>


                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" required class="form-control" />
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone" class="form-label mb-3">Phone</label>
                        <input type="text" class="form-control" name="phone" required />
                    </div>

                    <!-- Status Dropdown -->
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="0">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span class="text-danger" id="status_error"></span> <!-- Error container -->
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Add User</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Insurer User Modal --}}

<div class="modal fade" id="editInsurerUserModal" tabindex="-1" aria-labelledby="editInsurerUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInsurerUserModalLabel">Edit Insurer User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editInsurerUserForm">
                    @csrf
                    <input type="hidden" id="insurerUserId" name="insurer_user_id">

                    <!-- User Dropdown -->
                    <div class="form-group mb-3">
                        <label for="editUserName" class="form-label">Name</label>
                        <input type="text" name="edited_name" class="form-control" id="editUserName" required />
                    </div>

                    <div class="form-group mb-3">
                        <label for="editUserEmail" class="form-label">Email</label>
                        <input type="email" name="edited_email" required class="form-control" id="editUserEmail" />
                    </div>

                    <div class="form-group mb-3">
                        <label for="editUserPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="edited_phone" required id="editUserPhone" />
                    </div>

                    <!-- Status Dropdown -->
                    <div class="form-group mb-3">
                        <label for="editUserStatus">Status</label>
                        <select id="editUserStatus" name="edited_status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span class="text-danger" id="edited_status_error"></span> <!-- Error container -->
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Add Insurer User Script --}}
<script>
    $(document).ready(function() {
        $('#addInsurerUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $('.text-danger').text('');

            $.ajax({
                url: '{{ route('insurers.addInsurerUser') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Show success message
                    alert(response.message);
                    // Reload the page to reflect changes
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Display validation errors
                        var errors = xhr.responseJSON.errors;
                        for (var field in errors) {
                            $('#' + field + '_error').text(errors[field][
                                0
                            ]); // Display the first error message
                        }
                    } else if (xhr.status === 409) {
                        // Display conflict error
                        $('#user_id_error').text(xhr.responseJSON.errors.user_id[0]);
                    } else {
                        console.error('Error adding user:', xhr.responseText);
                        alert('An error occurred while adding the user.');
                    }
                }
            });
        });

        $('.edit-btn').on('click', function() {
            var insurerUserId = $(this).data('insurerassignment-id');

            $.ajax({
                url: '/insurers/editInsurerUser/' + insurerUserId,
                method: 'GET',
                success: function(response) {
                    $('#insurerUserId').val(response.id);
                    $('#editUserName').val(response.name);
                    $('#editUserEmail').val(response.email);
                    $('#editUserPhone').val(response.phone);
                    $('#editUserStatus').val(response.status);
                },
                error: function(xhr) {
                    console.error('Error fetching user data:', xhr.responseText);
                }
            });
        });

        $('#editInsurerUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var insurerUserId = $('#insurerUserId').val();

            // Clear previous errors
            $('.text-danger').text('');

            $.ajax({
                url: '/insurers/editInsurerUser/' + insurerUserId,
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Show success message
                    alert(response.message);
                    // Reload the page to reflect changes
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Display validation errors
                        var errors = xhr.responseJSON.errors;
                        for (var field in errors) {
                            $('#' + field + '_error').text(errors[field][
                                0
                            ]); // Display the first error message
                        }
                    } else if (xhr.status === 409) {
                        // Display conflict error
                        $('#edit_user_id_error').text(xhr.responseJSON.errors.edit_user_id[
                            0]);
                    } else {
                        console.error('Error updating user:', xhr.responseText);
                        alert('An error occurred while updating the user.');
                    }
                }
            });
        });
    });
</script>
