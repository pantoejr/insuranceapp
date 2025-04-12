@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('client-services.update', ['client' => $client, 'id' => $clientService->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Service Selection -->
                            <div class="col-md-6">
                                <input type="hidden" name="client_id" value="{{ $clientService->client_id }}">
                                <div class="form-group mb-3">
                                    <label for="service_id" class="form-label">Service</label>
                                    <select name="service_id" id="service_id"
                                        class="form-control select2 @error('service_id') is-invalid @enderror" required>
                                        <option value="0">Select Service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $clientService->service_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Cost and Currency -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="cost" class="form-label">Cost</label>
                                    <input type="number" name="cost" id="cost"
                                        class="form-control @error('cost') is-invalid @enderror"
                                        value="{{ old('cost', $clientService->cost) }}" required>
                                    @error('cost')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select name="currency" id="currency"
                                        class="form-control select2 @error('currency') is-invalid @enderror" required>
                                        <option value="usd" {{ $clientService->currency == 'usd' ? 'selected' : '' }}>USD
                                        </option>
                                        <option value="lrd" {{ $clientService->currency == 'lrd' ? 'selected' : '' }}>
                                            LRD
                                        </option>
                                    </select>
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Discount Fields -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="is_discounted" class="form-label">Discount Applied</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault" name="is_discounted" value="1"
                                            {{ old('is_discounted', $clientService->is_discounted) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Apply Discount</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select name="discount_type" id="discount_type" class="form-control select2">
                                        <option value="percentage"
                                            {{ $clientService->discount_type == 'percentage' ? 'selected' : '' }}>
                                            Percentage
                                        </option>
                                        <option value="fixed"
                                            {{ $clientService->discount_type == 'fixed' ? 'selected' : '' }}>
                                            Fixed Amount
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input type="text" name="discount" id="discount"
                                        class="form-control @error('discount') is-invalid @enderror"
                                        value="{{ old('discount', $clientService->discount) }}">
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $clientService->notes) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Service Duration -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="service_duration_start" class="form-label">Service Start Date</label>
                                    <input type="date" name="service_duration_start" id="service_duration_start"
                                        class="form-control @error('service_duration_start') is-invalid @enderror"
                                        value="{{ old('service_duration_start', $clientService->service_duration_start) }}"
                                        required>
                                    @error('service_duration_start')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="service_duration_end" class="form-label">Service End Date</label>
                                    <input type="date" name="service_duration_end" id="service_duration_end"
                                        class="form-control @error('service_duration_end') is-invalid @enderror"
                                        value="{{ old('service_duration_end', $clientService->service_duration_end) }}"
                                        required>
                                    @error('service_duration_end')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select name="payment_method" id="payment_method"
                                        class="form-control select2 @error('payment_method') is-invalid @enderror"
                                        required>
                                        <option value="cash"
                                            {{ $clientService->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer"
                                            {{ $clientService->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank
                                            Transfer</option>
                                        <option value="mobile_money"
                                            {{ $clientService->payment_method == 'mobile_money' ? 'selected' : '' }}>Mobile
                                            Money</option>
                                        <option value="check"
                                            {{ $clientService->payment_method == 'check' ? 'selected' : '' }}>Check
                                        </option>
                                        <option value="credit_card"
                                            {{ $clientService->payment_method == 'credit_card' ? 'selected' : '' }}>Credit
                                            Card</option>
                                        <option value="debit_card"
                                            {{ $clientService->payment_method == 'debit_card' ? 'selected' : '' }}>Debit
                                            Card</option>
                                        <option value="other"
                                            {{ $clientService->payment_method == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('payment_method')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group mb-3">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('clients.details', ['id' => $clientService->client_id]) }}"
                                        class="btn btn-light">Back To List</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="attachments" class="form-label">Attachments</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>File Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clientService->attachments as $index => $attachment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $attachment->file_name }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                        class="btn btn-primary btn-sm" target="_blank"><i
                                                            class="bi bi-arrow-down"></i></a>
                                                    <form
                                                        action="{{ route('attachments.destroy', ['id' => $attachment->id, 'clientId' => $client->id]) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm delete-btn"><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form action="{{ route('attachments.store', ['clientId' => $client->id]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    <label for="new_attachments" class="form-label mt-3">Add New Attachments</label>
                                    <div class="input-group mb-3">
                                        <input type="file" name="new_attachments[]" id="new_attachments" required
                                            class="form-control" multiple />
                                        <button class="btn btn-outline-success" type="submit"
                                            id="button-addon2">Submit</button>
                                    </div>
                                    @error('new_attachments')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteAttachment(attachmentId) {
            if (confirm('Are you sure you want to delete this attachment?')) {
                document.getElementById('attachment_id').value = attachmentId;
                document.getElementById('delete-attachment-form').submit();
            }
        }

        $(document).ready(function() {
            function toggleDiscountFields() {
                if ($('#flexSwitchCheckDefault').is(':checked')) {
                    $('#discount_type').closest('.form-group').show();
                    $('#discount').closest('.form-group').show();
                } else {
                    $('#discount_type').closest('.form-group').hide();
                    $('#discount').closest('.form-group').hide();
                    $('#discount_type').val('');
                    $('#discount').val('');
                    updateCost();
                }
            }

            function updateCost() {
                const baseCost = parseFloat($('#cost').val()) || 0;
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
                updateCost();
            });
        });
    </script>
@endsection
