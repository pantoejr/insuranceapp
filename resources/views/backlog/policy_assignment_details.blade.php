@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card border-0 shadow-sm">
					<div class="card-header">
						<h5 class="mb-0">Policy Assignment Details</h5>
					</div>
					<div class="card-body">
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
												<input type="text" class="form-control" id="client_id" value="{{ $policyAssignment->client->full_name ?? 'N/A' }}" readonly>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group mb-3">
												<label for="insurer_id" class="form-label">Insurer</label>
												<input type="text" class="form-control" id="insurer_id" value="{{ $policyAssignment->insurer->company_name ?? 'N/A' }}" readonly>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group mb-3">
												<label for="policy_id" class="form-label">Policy Type</label>
												<input type="text" class="form-control" id="policy_id" value="{{ $policyAssignment->policy->policy_name ?? 'N/A' }}" readonly>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group mb-3">
												<label for="policy_sub_type_id" class="form-label">Policy Sub Type</label>
												<input type="text" class="form-control" id="policy_sub_type_id" value="{{ $policyAssignment->policySubType->name ?? 'N/A' }}" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group mb-3">
												<label for="cost" class="form-label">Premium Amount</label>
												<input type="text" class="form-control" id="cost" value="${{ number_format($policyAssignment->cost, 2) }}" readonly>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group mb-3">
												<label for="terms_conditions" class="form-label">Terms & Conditions</label>
												<input type="text" class="form-control" id="terms_conditions" value="{{ $policyAssignment->notes ?? 'N/A' }}" readonly>
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
										<input type="text" class="form-control" id="currency" value="{{ strtoupper($policyAssignment->currency) ?? 'N/A' }}" readonly>
									</div>
									<div class="form-group mb-3">
										<label for="payment_method" class="form-label">Payment Method</label>
										<input type="text" class="form-control" id="payment_method" value="{{ ucfirst($policyAssignment->payment_method) ?? 'N/A' }}" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions mt-4 border-top pt-3">
							<div class="d-flex justify-content-between">
								<div>
									<a href="{{ route('backlog.policyAssignments') }}" class="btn btn-primary w-100">Back to List</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
