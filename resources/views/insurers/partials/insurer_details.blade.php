{{-- filepath: resources/views/insurers/partials/insurer_details.blade.php --}}
<div class="card shadow-sm mb-4 border-0" style="max-height: 450px;">
    <div class="card-header">
        <div class="card-title">{{ $model->company_name }} Details</div>
    </div>
    <div class="card-body" style=" overflow: auto;">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="row text-center">
                    @if ($model->logo)
                        <img src="{{ asset('storage/' . $model->logo) }}" alt="Logo" style="max-width: 20%;"
                            class="rounded-circle">
                    @else
                        <p>No logo available</p>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" value="{{ $model->company_name }}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" value="{{ $model->address }}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" value="{{ $model->email }}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" value="{{ $model->phone }}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="key_contact_person" class="form-label">Key Contact Person</label>
                            <input type="text" value="{{ $model->key_contact_person }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="key_contact_email" class="form-label">Key Contact Email</label>
                            <input type="text" value="{{ $model->key_contact_email }}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" disabled>{{ $model->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="website_url" class="form-label">Website URL</label>
                            <input type="text" value="{{ $model->website_url }}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" value="{{ ucfirst($model->status) }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <a href="{{ route('insurers.index') }}" class="btn btn-light mt-3">Back to List</a>
            </div>
        </div>
    </div>
</div>
