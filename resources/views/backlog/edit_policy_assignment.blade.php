@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Policy Assignment</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backlog.updatePolicyAssignment', $policyAssignment->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="policy_type_name" id="policy_type_name"
                                value="{{ $policyAssignment->policyType->name ?? '' }}">
                            <input type="hidden" name="policy_type_id" id="policy_type_id"
                                value="{{ $policyAssignment->policy_type_id }}">

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
                                                            <option value="{{ $client->id }}"
                                                                {{ $policyAssignment->client_id == $client->id ? 'selected' : '' }}>
                                                                {{ $client->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('client_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
                                                                {{ $policyAssignment->insurer_id == $insurer->id ? 'selected' : '' }}>
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
                                                        @if ($policyAssignment->policy)
                                                            <option value="{{ $policyAssignment->policy_id }}" selected>
                                                                {{ $policyAssignment->policy->policy_name }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    @error('policy_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="policy_sub_type_id" class="form-label">Policy Sub
                                                        Type</label>
                                                    <select name="policy_sub_type_id" id="policy_sub_type_id"
                                                        class="form-select">
                                                        <option value="">Select Policy Sub Type</option>
                                                        @if ($policyAssignment->policySubType)
                                                            <option value="{{ $policyAssignment->policy_sub_type_id }}"
                                                                selected>
                                                                {{ $policyAssignment->policySubType->name }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    @error('policy_sub_type_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
                                                            value="{{ old('cost', $policyAssignment->cost) }}" required>
                                                    </div>
                                                    @error('cost')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="terms_conditions" class="form-label">Terms &
                                                        Conditions</label>
                                                    <textarea name="terms_conditions" id="terms_conditions" class="form-control" rows="3">{{ old('terms_conditions', $policyAssignment->notes) }}</textarea>
                                                    @error('terms_conditions')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Vehicle Information Section (Conditional) -->
                                        <div id="vehicle-fields" class="row mb-4"
                                            style="display: {{ $policyAssignment->policyType && (str_contains($policyAssignment->policyType->name, 'Motor') || str_contains($policyAssignment->policyType->name, 'Auto')) ? 'block' : 'none' }};">
                                            <h6 class="section-header bg-light p-2 mb-3 border-all">
                                                <i class="fas fa-car me-2"></i>Vehicle Information
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="vehicle_make" class="form-label">Make & Model</label>
                                                        <input type="text" name="vehicle_make" id="vehicle_make"
                                                            class="form-control"
                                                            value="{{ old('vehicle_make', $policyAssignment->vehicle_make) }}">
                                                        @error('vehicle_make')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="vehicle_year" class="form-label">Year</label>
                                                        <input type="number" name="vehicle_year" id="vehicle_year"
                                                            min="1900" max="{{ date('Y') + 1 }}"
                                                            class="form-control"
                                                            value="{{ old('vehicle_year', $policyAssignment->vehicle_year) }}">
                                                        @error('vehicle_year')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="vehicle_VIN" class="form-label">VIN/Chassis
                                                            Number</label>
                                                        <input type="text" name="vehicle_VIN" id="vehicle_VIN"
                                                            class="form-control"
                                                            value="{{ old('vehicle_VIN', $policyAssignment->vehicle_VIN) }}">
                                                        @error('vehicle_VIN')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="vehicle_reg_number" class="form-label">Registration
                                                            Number</label>
                                                        <input type="text" name="vehicle_reg_number"
                                                            id="vehicle_reg_number" class="form-control"
                                                            value="{{ old('vehicle_reg_number', $policyAssignment->vehicle_reg_number) }}">
                                                        @error('vehicle_reg_number')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="vehicle_use_type" class="form-label">Vehicle Use
                                                        Type</label>
                                                    <select name="vehicle_use_type" id="vehicle_use_type"
                                                        class="form-select">
                                                        <option value="">Select Usage</option>
                                                        <option value="personal"
                                                            {{ old('vehicle_use_type', $policyAssignment->vehicle_use_type) == 'personal' ? 'selected' : '' }}>
                                                            Personal</option>
                                                        <option value="commercial"
                                                            {{ old('vehicle_use_type', $policyAssignment->vehicle_use_type) == 'commercial' ? 'selected' : '' }}>
                                                            Commercial</option>
                                                        <option value="corporate"
                                                            {{ old('vehicle_use_type', $policyAssignment->vehicle_use_type) == 'corporate' ? 'selected' : '' }}>
                                                            Rental</option>
                                                    </select>
                                                    @error('vehicle_use_type')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="policy_duration_start" class="form-label">Start
                                                        Date</label>
                                                    <input type="date" name="policy_duration_start" required
                                                        class="form-control @error('policy_duration_start') is-invalid @enderror"
                                                        value="{{ $policyAssignment->policy_duration_start }}" />
                                                    @error('policy_duration_start')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="policy_duration_end" class="form-label">End Date</label>
                                                    <input type="date" name="policy_duration_end" class="form-control @error('policy_duration_end') is-invalid @enderror"
                                                        value="{{ $policyAssignment->policy_duration_end }}" />
                                                    @error('policy_duration_end')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
                                            <select name="currency" id="currency"
                                                class="form-select @error('currency') is-invalid @enderror">
                                                <option value="">Select Currency</option>
                                                <option value="usd"
                                                    {{ old('currency', $policyAssignment->currency) == 'usd' ? 'selected' : '' }}>
                                                    USD</option>
                                                <option value="lrd"
                                                    {{ old('currency', $policyAssignment->currency) == 'lrd' ? 'selected' : '' }}>
                                                    LRD</option>
                                            </select>
                                            @error('currency')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select name="payment_method" id="payment_method" required
                                                class="form-select @error('payment_method') is-invalid @enderror">
                                                <option value="">Select Method</option>
                                                <option value="Cash"
                                                    {{ old('payment_method', $policyAssignment->payment_method) === 'cash' ? 'selected' : '' }}>
                                                    Cash</option>
                                                <option value="Cheque"
                                                    {{ old('payment_method', $policyAssignment->payment_method) === 'cheque' ? 'selected' : '' }}>
                                                    Cheque</option>
                                                <option value="Bank Transfer"
                                                    {{ old('payment_method', $policyAssignment->payment_method) === 'bank transfer' ? 'selected' : '' }}>
                                                    Bank Transfer</option>
                                                <option value="Credit Card"
                                                    {{ old('payment_method', $policyAssignment->payment_method) === 'credit card' ? 'selected' : '' }}>
                                                    Credit Card</option>
                                                <option value="Debit Card"
                                                    {{ old('payment_method', $policyAssignment->payment_method) === 'debit card' ? 'selected' : '' }}>
                                                    Debit Card</option>
                                                <option value="Deferred"
                                                    {{ old('payment_method', $policyAssignment->payment_method) === 'deferred' ? 'selected' : '' }}>
                                                    Deferred</option>
                                            </select>
                                            @error('payment_method')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="card border-0 shadow-sm discount-card mb-3">
                                            <div class="card-header bg-light">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_discounted"
                                                        id="is_discounted" value="1"
                                                        {{ old('is_discounted', $policyAssignment->is_discounted) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_discounted">Apply
                                                        Discount</label>
                                                </div>
                                            </div>
                                            <div class="card-body discount-fields"
                                                style="display: {{ old('is_discounted', $policyAssignment->is_discounted) ? 'block' : 'none' }};">
                                                <div class="form-group mb-3">
                                                    <label for="discount_type" class="form-label">Discount Type</label>
                                                    <select name="discount_type" id="discount_type"
                                                        class="form-select @error('discount_type') is-invalid @enderror">
                                                        <option value="">Select Type</option>
                                                        <option value="percentage"
                                                            {{ old('discount_type', $policyAssignment->discount_type) == 'percentage' ? 'selected' : '' }}>
                                                            Percentage</option>
                                                        <option value="fixed"
                                                            {{ old('discount_type', $policyAssignment->discount_type) == 'fixed' ? 'selected' : '' }}>
                                                            Fixed Amount</option>
                                                    </select>
                                                    @error('discount_type')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="discount" class="form-label">Discount Value</label>
                                                    <input type="number" name="discount" id="discount" step="0.01"
                                                        class="form-control @error('discount') is-invalid @enderror"
                                                        value="{{ old('discount', $policyAssignment->discount) }}">
                                                    @error('discount')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status"
                                                class="form-select @error('status') is-invalid @enderror">
                                                <option value="active"
                                                    {{ old('status', $policyAssignment->status) == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status', $policyAssignment->status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                                <option value="expired"
                                                    {{ old('status', $policyAssignment->status) == 'expired' ? 'selected' : '' }}>
                                                    Expired</option>
                                                <option value="cancelled"
                                                    {{ old('status', $policyAssignment->status) == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <h6 class="section-header bg-light p-2 mb-3 border-all">
                                            <i class="fas fa-file-alt me-2"></i>Policy Documents
                                        </h6>

                                        @if ($policyAssignment->documents->count() > 0)
                                            <div class="mb-3">
                                                <label class="form-label">Current Documents</label>
                                                <div class="document-list">
                                                    @foreach ($policyAssignment->documents as $document)
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <a href="{{ Storage::url($document->document_path) }}"
                                                                target="_blank" class="text-truncate"
                                                                style="max-width: 200px;">
                                                                <i class="fas fa-file-pdf me-1 text-danger"></i>
                                                                {{ basename($document->document_path) }}
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger delete-document"
                                                                data-id="{{ $document->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group mb-3">
                                            <label for="document_path" class="form-label">Upload Additional
                                                Documents</label>
                                            <input type="file" name="document_path[]" id="document_path"
                                                class="form-control @error('document_path') is-invalid @enderror"
                                                multiple>
                                            <small class="text-muted">You can upload multiple documents (PDF, JPG,
                                                PNG)</small>
                                            @error('document_path')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Actions -->
                            <div class="form-actions mt-4 border-top pt-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('backlog.policyAssignments') }}"
                                            class="btn btn-danger w-100">Cancel</a>
                                    </div>
                                    @can('update-backlog-policy-assignment')
                                        <div>
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="fas fa-save me-1"></i> Update Policy Assignment
                                            </button>
                                        </div>
                                    @endcan
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
            var originalCost = parseFloat("{{ $policyAssignment->cost }}") || 0;

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

                                // Set other fields
                                $('#policy_details').val(response.coverage_details || 'N/A');
                                $('#terms_conditions').val(response.terms_conditions || 'N/A');
                                $('#cost').val(response.premium_amount || '0.00');
                                $('#currency').val(response.currency || 'usd');
                                $('#payment_frequency').val(response.premium_frequency ||
                                    'yearly');

                                // Set original cost for discount calculations
                                originalCost = parseFloat(response.premium_amount) || 0;
                                $('#cost').data('original-cost', originalCost);

                                // Toggle vehicle fields if Motor Insurance
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
                // Toggle discount fields
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

            // Document deletion
            $('.delete-document').on('click', function() {
                var documentId = $(this).data('id');
                var $documentItem = $(this).closest('.d-flex');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/policy-documents/' + documentId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $documentItem.remove();
                                Swal.fire(
                                    'Deleted!',
                                    'The document has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was a problem deleting the document.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

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
