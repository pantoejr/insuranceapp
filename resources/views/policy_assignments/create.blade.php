@extends('layouts.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">Add Policy for <i><b>{{ $client->full_name }}</b></i></div>
                </div>
                <div class="card-body px-4">
                    <form action="{{ route('client-policies.store', ['client' => $client]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="insurer_id" class="form-label">Insurer</label>
                                    <select name="insurer_id" id="insurer_id"
                                        class="form-control @error('insurer_id')
                                        is-invalid
                                    @enderror">
                                        <option value="0">Select Insurer</option>
                                        @foreach ($insurers as $insurer)
                                            <option value="{{ $insurer->id }}">{{ $insurer->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('insurer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="from-group mb-3">
                                    <label for="policy_id" class="form-label">Policy</label>
                                    <select name="policy_id" id="policy_id"
                                        class="form-control @error('policy_id') is-invalid @enderror">
                                        <option value="0">Select Policy</option>
                                    </select>
                                    @error('policy_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="policy_details" class="form-label">Policy Details</label>
                                            <textarea name="policy_details" id="policy_details" class="form-control" readonly rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="payment_frequency" class="form-label">Payment Frequency</label>
                                            <input type="text" name="payment_frequency" id="payment_frequency"
                                                class="form-control @error('payment_frequency')
                                                    is-invalid
                                                @enderror"
                                                readonly />
                                            @error('payment_frequency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select name="payment_method" id="payment_method"
                                                class="form-control @error('payment_method')
                                                is-invalid
                                            @enderror">
                                                <option value="0">Select Payment Method</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Debit Card">Debit Card</option>
                                                <option value="Deferred">Deferred</option>
                                            </select>
                                            @error('payment_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="document_path" class="form-label">Document</label>
                                            <input type="file" name="document_path[]" id="document_path"
                                                class="form-control" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="cost" class="form-label">Cost</label>
                                            <input type="number" name="cost" id="cost"
                                                class="form-control @error('cost')
                                                is-invalid
                                            @enderror">
                                            @error('cost')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="currency" class="form-label">Currency</label>
                                            <select name="currency" id="currency"
                                                class="form-control @error('currency')
                                                is-invalid
                                            @enderror"
                                                readonly>
                                                <option value="0">Select Currency</option>
                                                <option value="usd" {{ old('currency') == 'usd' ? 'selected' : '' }}>USD
                                                </option>
                                                <option value="lrd" {{ old('currency') == 'lrd' ? 'selected' : '' }}>LRD
                                                </option>
                                            </select>
                                            @error('currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <label for="is_discounted">Discount</label>
                                                <input type="checkbox" name="is_discounted" id="is_discounted"
                                                    class="form-check-input" value="1" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="discount_type" class="form-label">Discount Type</label>
                                            <select name="discount_type" id="discount_type" class="form-control">
                                                <option value="0">Select Discount Type</option>
                                                <option value="percentage"
                                                    {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage
                                                </option>
                                                <option value="fixed"
                                                    {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="discount" class="form-label">Discount</label>
                                            <input type="number" name="discount" id="discount" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <input type="hidden" name="action" id="action" value="">
                                    <div class="col-md-3 mb-3">
                                        <button type="button" id="save-as-draft"
                                            class="btn btn-primary w-100">Draft</button>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" id="save-and-create"
                                            class="btn btn-primary w-100">Create</button>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" id="save-and-send"
                                            class="btn btn-success w-100">Submit</button>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                            class="btn btn-light w-100">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var originalCost = parseFloat($('#cost').val()) || 0;
            $('#cost').data('original-cost', originalCost);

            function fetchPolicies(insurerId) {
                $.ajax({
                    url: '/policies/get-insurer-policies/' + insurerId,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#policy_id').empty();

                        if (response.length > 0) {
                            response.forEach(function(policy) {
                                $('#policy_id').append('<option value="' + policy.id + '">' +
                                    policy.name + '</option>');
                                $('#policy_details').val(policy.coverage_details);
                                $('#currency').val(policy.currency);
                                $('#cost').val(policy.premium_amount);
                                $('#payment_frequency').val(policy.premium_frequency);

                                originalCost = parseFloat(policy.premium_amount) || 0;
                                $('#cost').data('original-cost', originalCost);
                            });
                        } else {
                            $('#policy_id').append(
                                '<option value="0">No active policies found.</option>');
                            $('#policy_details').val('');
                            $('#currency').val('');
                            $('#cost').val('');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching policies:', xhr.responseText);
                    }
                });
            }

            function updateCost() {
                var discountType = $('#discount_type').val();
                var discountAmount = parseFloat($('#discount').val()) || 0;

                if (discountType === 'percentage') {
                    var discountedCost = originalCost - (originalCost * (discountAmount / 100));
                } else if (discountType === 'fixed') {
                    var discountedCost = originalCost - discountAmount;
                } else {
                    var discountedCost = originalCost;
                }

                $('#cost').val(discountedCost.toFixed(2));
            }

            var initialInsurerId = $('#insurer_id').val();
            fetchPolicies(initialInsurerId);

            $('#insurer_id').on('change', function() {
                var insurerId = $(this).val();
                fetchPolicies(insurerId);
            });

            $('#is_discounted').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#discount_type').closest('.form-group').show();
                    $('#discount').closest('.form-group').show();
                } else {
                    $('#discount_type').closest('.form-group').hide();
                    $('#discount').closest('.form-group').hide();
                    $('#cost').val(originalCost.toFixed(2));
                }
            });

            $('#discount_type, #discount').on('change input', function() {
                updateCost();
            });

            $('#save-as-draft').on('click', function() {
                $('#action').val('save_as_draft');
                $('form').submit();
            });

            $('#save-and-create').on('click', function() {
                $('#action').val('save_and_create');
                $('form').submit();
            });

            $('#save-and-send').on('click', function() {
                $('#action').val('save_and_send');
                $('form').submit();
            });

            $('#discount_type').closest('.form-group').hide();
            $('#discount').closest('.form-group').hide();
        });
    </script>
@endsection
