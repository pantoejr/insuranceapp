@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Policy for <strong>{{ $client->full_name }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('client-policies.update', ['client' => $client, 'id' => $policyAssignment->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="policy_type_name" id="policy_type_name"
                                value="{{ $policyAssignment->policy->policyType->name ?? '' }}">
                            <input type="hidden" name="policy_type_id" id="policy_type_id"
                                value="{{ $policyAssignment->policy_type_id ?? '' }}">

                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="section-header bg-light p-2 mb-3 border-all">
                                            <i class="bi bi-file-earmark me-2"></i>Policy Information
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="insurer_id" class="form-label required">Insurer</label>
                                                    <select name="insurer_id" id="insurer_id"
                                                        class="form-select @error('insurer_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">Select Insurer</option>
                                                        @foreach ($insurers as $insurer)
                                                            <option value="{{ $insurer->id }}"
                                                                {{ old('insurer_id', $policyAssignment->insurer_id) == $insurer->id ? 'selected' : '' }}>
                                                                {{ $insurer->company_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('insurer_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="policy_id" class="form-label required">Policy Type</label>
                                                    <select name="policy_id" id="policy_id" class="form-select" required>
                                                        <option value="">Select Policy</option>
                                                        @foreach ($policies as $policy)
                                                            <option value="{{ $policy->id }}"
                                                                {{ old('policy_id', $policyAssignment->policy_id) == $policy->id ? 'selected' : '' }}>
                                                                {{ $policy->policyType->name }}
                                                            </option>
                                                        @endforeach
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
                                                        class="form-select">
                                                        <option value="">Select Policy Sub Type</option>
                                                        @foreach ($policySubTypes as $subType)
                                                            <option value="{{ $subType->id }}"
                                                                {{ old('policy_sub_type_id', $policyAssignment->policy_sub_type_id) == $subType->id ? 'selected' : '' }}>
                                                                {{ $subType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="cost" class="form-label required">Premium Amount</label>
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text">{{ $policyAssignment->currency == 'usd' ? '$' : 'L$' }}</span>
                                                        <input type="number" name="cost" id="cost" step="0.01"
                                                            value="{{ old('cost', $policyAssignment->cost) }}"
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
                                                    <textarea name="terms_conditions" id="terms_conditions" class="form-control" rows="3">{{ old('terms_conditions', $policyAssignment->terms_conditions) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="policy_details" class="form-label">Coverage Details</label>
                                                    <textarea name="policy_details" id="policy_details" class="form-control" rows="3">{{ old('policy_details', $policyAssignment->policy_details) }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Vehicle Information Section -->
                                        @if (stripos($policyAssignment->policy->policy_name, 'Motor') || stripos($policyAssignment->policyType->name, 'Auto'))
                                            <div id="vehicle-fields" class="row mb-4" style="display: block;">
                                                <h6 class="section-header bg-light p-2 mb-3 border-all">
                                                    <i class="fas fa-car me-2"></i>Vehicle Information
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="vehicle_make" class="form-label">Make &
                                                                Model</label>
                                                            <input type="text" name="vehicle_make" id="vehicle_make"
                                                                value="{{ old('vehicle_make', $policyAssignment->vehicle_make) }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="vehicle_year" class="form-label">Year</label>
                                                            <input type="text" name="vehicle_year" id="vehicle_year"
                                                                value="{{ old('vehicle_year', $policyAssignment->vehicle_year) }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="vehicle_VIN" class="form-label">VIN/Chassis
                                                                Number</label>
                                                            <input type="text" name="vehicle_VIN" id="vehicle_VIN"
                                                                value="{{ old('vehicle_VIN', $policyAssignment->vehicle_VIN) }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="vehicle_reg_number"
                                                                class="form-label">Registration
                                                                Number</label>
                                                            <input type="text" name="vehicle_reg_number"
                                                                id="vehicle_reg_number"
                                                                value="{{ old('vehicle_reg_number', $policyAssignment->vehicle_reg_number) }}"
                                                                class="form-control">
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
                                                                <option value="rental"
                                                                    {{ old('vehicle_use_type', $policyAssignment->vehicle_use_type) == 'rental' ? 'selected' : '' }}>
                                                                    Rental</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <h6 class="section-header bg-light p-2 mb-3 border-all">
                                            <i class="fas fa-money-bill-wave me-2"></i>Payment Details
                                        </h6>

                                        <div class="form-group mb-3">
                                            <label for="currency" class="form-label">Currency</label>
                                            <select name="currency" id="currency" class="form-select">
                                                <option value="usd"
                                                    {{ old('currency', $policyAssignment->currency) == 'usd' ? 'selected' : '' }}>
                                                    USD</option>
                                                <option value="lrd"
                                                    {{ old('currency', $policyAssignment->currency) == 'lrd' ? 'selected' : '' }}>
                                                    LRD</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="payment_frequency" class="form-label">Payment Frequency</label>
                                            <select name="payment_frequency" id="payment_frequency" class="form-select">
                                                <option value="monthly"
                                                    {{ old('payment_frequency', $policyAssignment->payment_frequency) == 'monthly' ? 'selected' : '' }}>
                                                    Monthly</option>
                                                <option value="quarterly"
                                                    {{ old('payment_frequency', $policyAssignment->payment_frequency) == 'quarterly' ? 'selected' : '' }}>
                                                    Quarterly</option>
                                                <option value="half-yearly"
                                                    {{ old('payment_frequency', $policyAssignment->payment_frequency) == 'half-yearly' ? 'selected' : '' }}>
                                                    Half-Yearly</option>
                                                <option value="yearly"
                                                    {{ old('payment_frequency', $policyAssignment->payment_frequency) == 'yearly' ? 'selected' : '' }}>
                                                    Yearly</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select name="payment_method" id="payment_method" class="form-select">
                                                <option value="">Select Method</option>
                                                <option value="Cash"
                                                    {{ old('payment_method', $policyAssignment->payment_method) == 'Cash' ? 'selected' : '' }}>
                                                    Cash</option>
                                                <option value="Cheque"
                                                    {{ old('payment_method', $policyAssignment->payment_method) == 'Cheque' ? 'selected' : '' }}>
                                                    Cheque</option>
                                                <option value="Bank Transfer"
                                                    {{ old('payment_method', $policyAssignment->payment_method) == 'Bank Transfer' ? 'selected' : '' }}>
                                                    Bank Transfer</option>
                                                <option value="Credit Card"
                                                    {{ old('payment_method', $policyAssignment->payment_method) == 'Credit Card' ? 'selected' : '' }}>
                                                    Credit Card</option>
                                                <option value="Debit Card"
                                                    {{ old('payment_method', $policyAssignment->payment_method) == 'Debit Card' ? 'selected' : '' }}>
                                                    Debit Card</option>
                                                <option value="Deferred"
                                                    {{ old('payment_method', $policyAssignment->payment_method) == 'Deferred' ? 'selected' : '' }}>
                                                    Deferred</option>
                                            </select>
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
                                                    <select name="discount_type" id="discount_type" class="form-select">
                                                        <option value="">Select Type</option>
                                                        <option value="percentage"
                                                            {{ old('discount_type', $policyAssignment->discount_type) == 'percentage' ? 'selected' : '' }}>
                                                            Percentage</option>
                                                        <option value="fixed"
                                                            {{ old('discount_type', $policyAssignment->discount_type) == 'fixed' ? 'selected' : '' }}>
                                                            Fixed Amount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="discount" class="form-label">Discount Value</label>
                                                    <input type="number" name="discount" id="discount" step="0.01"
                                                        value="{{ old('discount', $policyAssignment->discount) }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <h6 class="section-header bg-light p-2 mb-3 border-all">
                                            <i class="fas fa-file-alt me-2"></i>Policy Documents
                                        </h6>

                                        <div class="form-group mb-3">
                                            <label for="document_path" class="form-label">Upload Additional
                                                Documents</label>
                                            <input type="file" name="document_path[]" id="document_path"
                                                class="form-control" multiple>
                                            <small class="text-muted">You can upload multiple documents (PDF, JPG,
                                                PNG)</small>
                                        </div>

                                        @if ($policyAssignment->documents->count() > 0)
                                            <div class="mt-3">
                                                <label class="form-label">Existing Documents</label>
                                                <ul class="list-group">
                                                    @foreach ($policyAssignment->documents as $document)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <a href="{{ Storage::url($document->path) }}"
                                                                target="_blank">{{ basename($document->path) }}</a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger delete-document"
                                                                data-id="{{ $document->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions mt-4 border-top pt-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Cancel
                                        </a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Update Policy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Toggle discount fields
                $('#is_discounted').change(function() {
                    if ($(this).is(':checked')) {
                        $('.discount-fields').slideDown();
                    } else {
                        $('.discount-fields').slideUp();
                    }
                });

                // Document deletion
                $('.delete-document').click(function() {
                    if (confirm('Are you sure you want to delete this document?')) {
                        const documentId = $(this).data('id');
                        $.ajax({
                            url: '{{ route('attachments.destroy', '') }}/' + documentId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                location.reload();
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
