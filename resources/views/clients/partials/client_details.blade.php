<div class="card shadow-sm mb-3 border-0">
    <div class="card-header">
        <div class="card-title">
            {{ $model->full_name }} Details
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="p-3">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            @if ($model->photo_picture)
                                <img src="{{ asset('storage/' . $model->photo_picture) }}" alt="Client Photo"
                                    style="max-width: 20%;" class="rounded-circle">
                            @else
                                <img src="#" alt="No Photo" style="max-width: 100%; display: none;">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" disabled value="{{ $model->client_type }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" disabled value="{{ $model->full_name }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" disabled value="{{ $model->email }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" disabled value="{{ $model->phone }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" disabled value="{{ ucfirst($model->status) }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" disabled value="{{ $model->address }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="text" disabled value="{{ $model->date_of_birth }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('clients.index') }}" class="btn btn-light">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
