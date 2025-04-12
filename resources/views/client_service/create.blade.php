@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('client-services.store', ['client' => $client]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <div class="form-group mb-3">
                                    <label for="service_id" class="form-label">Service</label>
                                    <select name="service_id" id="service_id"
                                        class="form-control select2 @error('service_id')
                                        is-invalid
                                    @enderror"
                                        required>
                                        <option value="0">Select Service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="cost" class="form-label">Cost</label>
                                    <input type="number" name="cost" id="cost"
                                        class="form-control @error('cost')
                                        is-invalid
                                    @enderror"
                                        value="{{ old('cost') }}" required>
                                    @error('cost')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select name="currency" id="currency"
                                        class="form-control select2 @error('currency')
                                        is-invalid
                                    @enderror"
                                        required>
                                        <option value="0">Select Currency</option>
                                        <option value="usd">USD</option>
                                        <option value="lrd">LRD</option>
                                    </select>
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="is_discounted" class="form-label"></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault" name="is_discounted" value="1"
                                            {{ old('is_discounted', $clientService->is_discounted ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Discount</label>
                                        @error('is_discounted')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select name="discount_type" id="discount_type" class="form-control select2">
                                        <option value="0">Select Discount Type</option>
                                        <option value="percentage"
                                            {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage
                                        </option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>
                                            Fixed Amount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input type="text" name="discount" id="discount"
                                        class="form-control @error('discount')
                                        is-invalid
                                    @enderror"
                                        value="{{ old('discount') }}">
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" rows="2"
                                        class="form-control @error('notes')
                                        is-invalid
                                    @enderror">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="frequency" class="form-label">Payment Frequency</label>
                                    <input type="text" name="frequency" id="frequency" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="service_document" class="form-label">Document(s)</label>
                                <input type="file" name="service_document[]" id="service_document"
                                    class="form-control" multiple />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="service_duration_start" class="form-label">Service Start Date</label>
                                    <input type="date" name="service_duration_start" id="service_duration_start"
                                        class="form-control @error('service_duration_start')
                                        is-invalid
                                    @enderror"
                                        value="{{ old('service_duration_start') }}" required>
                                    @error('service_duration_start')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="service_duration_end" class="form-label">Service End Date</label>
                                    <input type="date" name="service_duration_end" id="service_duration_end"
                                        class="form-control @error('service_duration_end')
                                        is-invalid
                                    @enderror"
                                        value="{{ old('service_duration_end') }}" required>
                                    @error('service_duration_end')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select name="payment_method" id="payment_method"
                                        class="form-control select2 @error('payment_method')
                                        is-invalid
                                    @enderror"
                                        required>
                                        <option value="0">Select Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="mobile_money">Mobile Money</option>
                                        <option value="check">Check</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="other">Other</option>
                                    </select>
                                    @error('payment_method')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ route('clients.details', ['id' => $client->id]) }}"
                                        class="btn btn-light">Back To List</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function toggleDiscountFields() {
                if ($('#flexSwitchCheckDefault').is(':checked')) {
                    $('#discount_type').closest('.form-group').show();
                    $('#discount').closest('.form-group').show();
                } else {
                    $('#discount_type').closest('.form-group').hide();
                    $('#discount').closest('.form-group').hide();
                    // Clear discount fields when hidden
                    $('#discount_type').val(0).trigger('change');
                    $('#discount').val('');
                    updateCost();
                }
            }

            function updateCost() {
                const baseCost = parseFloat($('#cost').data('base-cost')) || 0; // Base cost saved as data attribute
                const discountType = $('#discount_type').val();
                const discountValue = parseFloat($('#discount').val()) || 0;

                let finalCost = baseCost;

                if ($('#flexSwitchCheckDefault').is(':checked')) {
                    if (discountType === 'percentage' && discountValue > 0 && discountValue <= 100) {
                        finalCost = baseCost - (baseCost * (discountValue / 100));
                    } else if (discountType === 'fixed' && discountValue > 0) {
                        finalCost = baseCost - discountValue;
                    }
                }

                finalCost = Math.max(finalCost, 0);

                $('#cost').val(finalCost.toFixed(2));
            }

            toggleDiscountFields();

            $('#flexSwitchCheckDefault').on('change', function() {
                toggleDiscountFields();
                updateCost();
            });

            $('#discount_type, #discount').on('input change', function() {
                updateCost(); // Recalculate cost on discount type or value change
            });

            // Clear and update service data on service selection
            $('#service_id').on('change', function() {
                var serviceId = $(this).val();

                if (serviceId == 0) {
                    // Clear relevant fields if the selected value is 0
                    $('#cost').val('');
                    $('#notes').val('');
                    $('#frequency').val('');
                    $('#currency').val('').trigger('change');
                    $('#cost').data('base-cost', 0); // Clear base cost
                } else {
                    // If a valid service is selected, fetch service details via AJAX
                    $.ajax({
                        url: "/services/getServiceDetails/" + serviceId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#cost').val(data.cost);
                            $('#cost').data('base-cost', data.cost);
                            $('#notes').val(data.terms_conditions);
                            $('#frequency').val(data.frequency);
                            // Save base cost for discount calculations
                            $('#currency').val(data.currency).trigger('change');
                            updateCost(); // Recalculate cost with the new base cost
                        },
                        error: function(xhr, status, error) {
                            swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to fetch service details.',
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
