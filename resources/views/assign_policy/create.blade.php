@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">{{ $title }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assign-policy.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="policy_type_name" id="policy_type_name">
                            <input type="hidden" name="policy_type_id" id="policy_type_id">
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="section-header bg-light p-2 mb-3 border-all">
                                            <i class="bi bi-file-earmark me-2"></i>Policy Information
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="client_id" class="form-label">Client</label>
                                                    <select name="client_id" id="client_id"
                                                        class="form-control @error('client_id') is-invalid @enderror">
                                                        <option value="0">Select Client</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}">{{ $client->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="insurer_id" class="form-label required">Insurer</label>
                                                    <select name="insurer_id" id="insurer_id"
                                                        class="form-select @error('insurer_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">Select Insurer</option>
                                                        @foreach ($insurers as $insurer)
                                                            <option value="{{ $insurer->id }}"
                                                                {{ old('insurer_id') == $insurer->id ? 'selected' : '' }}>
                                                                {{ $insurer->company_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('insurer_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="policy_id" class="form-label required">Policy Type</label>
                                                    <select name="policy_id" id="policy_id" class="form-select" required>
                                                        <option value="">Select Policy</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="policy_sub_type_id" class="form-label">Policy Sub
                                                        Type</label>
                                                    <select name="policy_sub_type_id" id="policy_sub_type_id"
                                                        class="form-select" required>
                                                        <option value="">Select Policy Sub Type</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="cost" class="form-label required">Premium Amount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-currency-dollar"></i></span>
                                                        <input type="number" name="cost" id="cost" step="0.01"
                                                            class="form-control @error('cost') is-invalid @enderror"
                                                            required>
                                                    </div>
                                                    @error('cost')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="terms_conditions" class="form-label">Terms &
                                                        Conditions</label>
                                                    <textarea name="terms_conditions" id="terms_conditions" class="form-control" rows="3" readonly></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="policy_details" class="form-label">Coverage Details</label>
                                                    <textarea name="policy_details" id="policy_details" class="form-control" rows="3" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Vehicle Information Section (Conditional) -->
                                        <div id="vehicle-fields" class="row mb-4" style="display: none;">
                                            <h6 class="section-header bg-light p-2 mb-3 border-all">
                                                <i class="fas fa-car me-2"></i>Vehicle Information
                                            </h6>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="vehicle_make" class="form-label">Make & Model</label>
                                                    <input type="text" name="vehicle_make" id="vehicle_make"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="vehicle_year" class="form-label">Year</label>
                                                    <input type="number" name="vehicle_year" id="vehicle_year"
                                                        min="1900" max="{{ date('Y') + 1 }}" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="vehicle_VIN" class="form-label">VIN/Chassis
                                                        Number</label>
                                                    <input type="text" name="vehicle_VIN" id="vehicle_VIN"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="vehicle_reg_number" class="form-label">Registration
                                                        Number</label>
                                                    <input type="text" name="vehicle_reg_number"
                                                        id="vehicle_reg_number" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="vehicle_use_type" class="form-label">Vehicle Use
                                                        Type</label>
                                                    <select name="vehicle_use_type" id="vehicle_use_type"
                                                        class="form-select">
                                                        <option value="0">Select Usage</option>
                                                        <option value="personal">Personal</option>
                                                        <option value="commercial">Commercial</option>
                                                        <option value="corporate">Rental</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="section-header bg-light p-2 mb-3 border-all">
                                            <i class="fas fa-money-bill-wave me-2"></i>Payment Details
                                        </h6>

                                        <div class="form-group mb-3">
                                            <label for="currency" class="form-label">Currency</label>
                                            <select name="currency" id="currency" class="form-select" readonly>
                                                <option value="">Select Currency</option>
                                                <option value="usd">USD</option>
                                                <option value="lrd">LRD</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="payment_frequency" class="form-label">Payment Frequency</label>
                                            <input type="text" name="payment_frequency" id="payment_frequency"
                                                class="form-control" readonly>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select name="payment_method" id="payment_method" class="form-select">
                                                <option value="">Select Method</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Debit Card">Debit Card</option>
                                                <option value="Deferred">Deferred</option>
                                            </select>
                                        </div>

                                        <div class="card border-0 shadow-sm discount-card mb-3">
                                            <div class="card-header bg-light">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_discounted"
                                                        id="is_discounted" value="1">
                                                    <label class="form-check-label" for="is_discounted">Apply
                                                        Discount</label>
                                                </div>
                                            </div>
                                            <div class="card-body discount-fields" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <label for="discount_type" class="form-label">Discount
                                                        Type</label>
                                                    <select name="discount_type" id="discount_type" class="form-select">
                                                        <option value="">Select Type</option>
                                                        <option value="percentage">Percentage</option>
                                                        <option value="fixed">Fixed Amount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="discount" class="form-label">Discount Value</label>
                                                    <input type="number" name="discount" id="discount" step="0.01"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <h6 class="section-header bg-light p-2 mb-3 border-all">
                                            <i class="fas fa-file-alt me-2"></i>Policy Documents
                                        </h6>

                                        <div class="form-group mb-3">
                                            <label for="document_path" class="form-label">Upload Documents</label>
                                            <input type="file" name="document_path[]" id="document_path"
                                                class="form-control" multiple>
                                            <small class="text-muted">You can upload multiple documents (PDF, JPG,
                                                PNG)</small>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Form Actions -->
                            <div class="form-actions mt-4 border-top pt-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('assign-policy.index') }}"
                                            class="btn btn-danger w-100">Cancel</a>
                                    </div>
                                    <div>
                                        <button type="button" id="save-as-draft" class="btn btn-primary me-2">
                                            <i class="fas fa-save me-1"></i> Save Draft
                                        </button>
                                        <button type="button" id="save-and-create" class="btn btn-success me-2">
                                            <i class="fas fa-plus-circle me-1"></i> Create
                                        </button>
                                        <input type="hidden" name="action" id="action" value="">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .section-header {
            font-size: 1rem;
            font-weight: 600;
            color: #495057;
        }

        .required:after {
            content: " *";
            color: #dc3545;
        }

        .discount-card {
            transition: all 0.3s ease;
        }

        .form-control:read-only,
        .form-select:read-only {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        $(document).ready(function() {
            var originalCost = 0;

            // Initialize form elements
            getInsurerPolicies();
            getPolicyDetails();
            initDiscountToggle();

            // Make sure currency and payment frequency are properly set when policy changes
            function syncReadOnlyFields() {
                $('#currency').val($('#currency option:first').val());
                $('#payment_frequency').val('');
            }

            function getInsurerPolicies() {
                $('#insurer_id').change(function() {
                    var insurerId = $(this).val();

                    if (insurerId > 0) {
                        $.ajax({
                            url: '/assign-policy/getInsurerPolicies/' + insurerId,
                            type: 'GET',
                            success: function(response) {

                                var policiesDropdown = $('#policy_id');
                                policiesDropdown.empty();
                                policiesDropdown.append(
                                    '<option value="">Select Policy</option>');

                                $.each(response, function(index, policy) {
                                    policiesDropdown.append('<option value="' + policy
                                        .id + '">' + policy.policy_name +
                                        '</option>');
                                });



                                // Reset dependent fields
                                $('#policy_details').val('');
                                $('#terms_conditions').val('');
                                $('#cost').val('');
                                syncReadOnlyFields();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error",
                                    text: xhr.responseText,
                                    icon: "error",
                                });
                                showAlert('Error loading policies. Please try again.',
                                    'danger');
                            }
                        });
                    } else {
                        $('#policy_id').empty().append('<option value="">Select Policy</option>');
                        $('#policy_details').val('');
                        $('#terms_conditions').val('');
                        $('#cost').val('');
                        syncReadOnlyFields();
                    }
                });
            }

            function getPolicyDetails() {
                $('#policy_id').change(function() {
                    var policyId = $(this).val();

                    if (policyId > 0) {
                        $.ajax({
                            url: '/assign-policy/getPolicyDetails/' + policyId,
                            type: 'GET',
                            success: function(response) {

                                $('#policy_type_id').val(response.policy_type.id);
                                $('#policy_type_name').val(response.policy_type.name);

                                var policySubTypeDropdown = $('#policy_sub_type_id');
                                policySubTypeDropdown.empty();
                                policySubTypeDropdown.append(
                                    '<option value="">Select Policy Sub Type</option>');

                                if (response.policy_type.policy_sub_types) {
                                    $.each(response.policy_type.policy_sub_types, function(
                                        index, subType) {
                                        policySubTypeDropdown.append(
                                            $('<option></option>')
                                            .val(subType.id)
                                            .text(subType.name)
                                            .prop('selected', (subType.id ==
                                                response.policy_sub_type_id))
                                        );
                                    });
                                }

                                // 3. Set other fields
                                $('#policy_details').val(response.coverage_details || 'N/A');
                                $('#terms_conditions').val(response.terms_conditions || 'N/A');
                                $('#cost').val(response.premium_amount || '0.00');
                                $('#currency').val(response.currency || 'usd');
                                $('#payment_frequency').val(response.premium_frequency ||
                                    'yearly');

                                // 4. Set original cost for discount calculations
                                originalCost = parseFloat(response.premium_amount) || 0;
                                $('#cost').data('original-cost', originalCost);

                                 // 5. Toggle vehicle fields if Motor Insurance
                                 if (response.policy_type.name.includes('Motor') || response
                                    .policy_type.name.includes('Auto')) {
                                    $('#vehicle-fields').slideDown();
                                } else {
                                    $('#vehicle-fields').slideUp();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error",
                                    text: xhr.responseText,
                                    icon: "error"
                                });
                                showAlert('Error loading policy details. Please try again.',
                                    'danger');
                            }
                        });
                    } else {
                        resetPolicyFields();
                    }
                });
            }

            function initDiscountToggle() {
                // Initialize discount fields
                $('.discount-fields').hide();

                $('#is_discounted').change(function() {
                    if ($(this).is(':checked')) {
                        $('.discount-fields').slideDown();
                    } else {
                        $('.discount-fields').slideUp();
                        // Reset discount fields
                        $('#discount_type').val('');
                        $('#discount').val('');
                        $('#cost').val(originalCost.toFixed(2));
                    }
                });

                // Handle discount calculations
                $('#discount_type, #discount').on('change input', function() {
                    updateCost();
                });
            }

            function updateCost() {
                var discountType = $('#discount_type').val();
                var discountAmount = parseFloat($('#discount').val()) || 0;
                var discountedCost = originalCost; // Default to original cost

                if ($('#is_discounted').is(':checked')) {
                    if (discountType === 'percentage') {
                        discountedCost = originalCost - (originalCost * (discountAmount / 100));
                    } else if (discountType === 'fixed') {
                        discountedCost = originalCost - discountAmount;
                    }
                }

                // Ensure the cost doesn't go below 0
                discountedCost = Math.max(discountedCost, 0);
                $('#cost').val(discountedCost.toFixed(2));
            }

            // Form submission handlers
            $('#save-as-draft').on('click', function() {
                $('#action').val('save_as_draft');
                validateAndSubmit();
            });

            $('#save-and-create').on('click', function() {
                $('#action').val('save_and_create');
                validateAndSubmit();
            });


            function validateAndSubmit() {
                // Basic validation
                let isValid = true;

                if ($('#insurer_id').val() === '') {
                    showAlert('Please select an insurer', 'danger');
                    isValid = false;
                }

                if ($('#policy_id').val() === '') {
                    showAlert('Please select a policy type', 'danger');
                    isValid = false;
                }

                if ($('#cost').val() === '' || $('#cost').val() <= 0) {
                    showAlert('Please enter a valid premium amount', 'danger');
                    isValid = false;
                }

                if (isValid) {
                    $('form').submit();
                }
            }

            function showAlert(message, type) {
                $('.alert-dismissible').remove();

                const alert = $(`
                <div class="alert alert-${type} alert-dismissible fade show mb-4">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);

                // Insert after the card header
                $('.card-header').after(alert);

                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    alert.alert('close');
                }, 5000);
            }
        });
    </script>
@endsection
