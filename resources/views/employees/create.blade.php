@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.store', ['clientId' => $clientId]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <center>
                            <img id="photo-preview" src="#" alt="Photo Preview"
                                style="display: none; margin-top: 10px; max-height: 200px; border: 1px solid #ddd;">
                        </center>
                        <div class="form-group mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control @error('profile_picture') is-invalid @enderror"
                                id="profile_picture" name="profile_picture" onchange="previewPhoto()">
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="client_id" class="form-label">Client</label>
                                    @if ($clientId)
                                        <input type="hidden" name="client_id" value="{{ $clientId }}">
                                        <p>Default Client Selected</p>
                                    @else
                                        <select class="form-control @error('client_id') is-invalid @enderror" id="client_id"
                                            name="client_id" required>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">
                                                    {{ $client->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="employee_name" class="form-label">Employee Name</label>
                                    <input type="text" class="form-control @error('employee_name') is-invalid @enderror"
                                        id="employee_name" placeholder="Enter employee name" required
                                        @error('employee_name') aria-describedby="employee_name-error" @enderror
                                        name="employee_name">
                                    @error('employee_name')
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
                                        id="email" placeholder="Enter email" required
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
                                        id="phone" placeholder="Enter phone" name="phone">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror"
                                        id="position" placeholder="Enter position" name="position">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                        name="gender" required>
                                        <option value="male">Male</option>
                                        <option value="female"> Female</option>
                                        <option value="other"> Other</option>
                                    </select>
                                    @error('gender')
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
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
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
                                        id="address" placeholder="Enter address" name="address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" name="date_of_birth">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Save</button>
                            @if ($clientId)
                                <a href="{{ route('clients.details', ['id' => $clientId]) }}" class="btn btn-light">Back
                                    to List</a>
                            @else
                                <a href="{{ route('employees.index') }}" class="btn btn-light">Back to List</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewPhoto() {
            const photo = document.getElementById('profile_picture').files[0];
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
@endsection
