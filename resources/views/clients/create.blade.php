@extends('layouts.app')

@section('content')
    @can('add-client')
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4" style="border:none;">
                    <div class="card-header" style="border:none;">
                        <div class="card-title">Create Client</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <center><img id="photo-preview" src="#" alt="Photo Preview"
                                    style="display: none; margin-top: 10px; max-height: 100px; border: 1px solid #ddd;">
                            </center>
                            <div class="form-group mb-3">
                                <label for="photo_picture" class="form-label">Photo</label>
                                <input type="file" class="form-control @error('photo_picture') is-invalid @enderror"
                                    id="photo_picture" name="photo_picture" onchange="previewPhoto()">
                                @error('photo_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="client_type" class="form-label">Client Type</label>
                                        <select name="client_type" id="client_type" class="form-control"
                                            onchange="toggleDateOfBirth()">
                                            <option value="0"> Please select Client Type</option>
                                            <option value="Individual"
                                                {{ old('client_type') == 'Individual' ? 'selected' : '' }}>
                                                Individual</option>
                                            <option value="Company" {{ old('client_type') == 'Company' ? 'selected' : '' }}>
                                                Company</option>
                                        </select>
                                        @error('client_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="full_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                            id="full_name" value="{{ old('full_name') }}" placeholder="Enter full name" required
                                            @error('full_name') aria-describedby="full_name-error" @enderror name="full_name">
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" value="{{ old('email') }}" placeholder="Enter email" required
                                            @error('email') aria-describedby="email-error" @enderror name="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" value="{{ old('phone') }}" placeholder="Enter phone" name="phone">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" value="{{ old('address') }}" placeholder="Enter address"
                                            name="address">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2" id="date-of-birth-row" style="display: none;">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date"
                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" value="{{ old('date_of_birth') }}" name="date_of_birth">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success">Save</button>
                                <a href="{{ route('clients.index') }}" class="btn btn-light">Back to List</a>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    function toggleDateOfBirth() {
                        const clientType = document.getElementById('client_type').value;
                        const dateOfBirthRow = document.getElementById('date-of-birth-row');
                        if (clientType === 'Individual') {
                            dateOfBirthRow.style.display = 'block';
                        } else {
                            dateOfBirthRow.style.display = 'none';
                        }
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        toggleDateOfBirth();
                    });
                </script>
            </div>
        </div>

        <script>
            function previewPhoto() {
                const photo = document.getElementById('photo_picture').files[0];
                const preview = document.getElementById('photo-preview');
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }

                if (photo) {
                    reader.readAsDataURL(photo);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            }
        </script>
    @endcan
@endsection
