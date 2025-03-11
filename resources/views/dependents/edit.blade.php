@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('dependents.update', $dependent->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <center>
                            @if ($dependent->profile_picture)
                                <img id="photo-preview" src="{{ asset('storage/' . $dependent->profile_picture) }}"
                                    alt="Photo Preview"
                                    style="margin-top: 10px; max-height: 200px; border: 1px solid #ddd;">
                            @else
                                <img id="photo-preview" src="#" alt="Photo Preview"
                                    style="display: none; margin-top: 10px; max-height: 200px; border: 1px solid #ddd;">
                            @endif
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
                                    <label for="employee_id" class="form-label">Employee</label>
                                    <select class="form-control @error('employee_id') is-invalid @enderror" id="employee_id"
                                        name="employee_id" required>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ old('employee_id', $dependent->employee_id) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->employee_name . ' (' . $employee->client->full_name . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="dependent_name" class="form-label">Dependent Name</label>
                                    <input type="text" class="form-control @error('dependent_name') is-invalid @enderror"
                                        id="dependent_name" value="{{ old('dependent_name', $dependent->dependent_name) }}"
                                        placeholder="Enter dependent name" required
                                        @error('dependent_name') aria-describedby="dependent_name-error" @enderror
                                        name="dependent_name">
                                    @error('dependent_name')
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
                                        id="email" value="{{ old('email', $dependent->email) }}"
                                        placeholder="Enter email" required
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
                                        id="phone" value="{{ old('phone', $dependent->phone) }}"
                                        placeholder="Enter phone" name="phone">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="relationship" class="form-label">Relationship</label>
                                    <input type="text" class="form-control @error('relationship') is-invalid @enderror"
                                        id="relationship" value="{{ old('relationship', $dependent->relationship) }}"
                                        placeholder="Enter relationship" name="relationship">
                                    @error('relationship')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                        name="gender" required>
                                        <option value="male"
                                            {{ old('gender', $dependent->gender) == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $dependent->gender) == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other"
                                            {{ old('gender', $dependent->gender) == 'other' ? 'selected' : '' }}>Other
                                        </option>
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
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" value="{{ old('address', $dependent->address) }}"
                                        placeholder="Enter address" name="address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="active"
                                            {{ old('status', $dependent->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $dependent->status) == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
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
                                        id="date_of_birth" value="{{ old('date_of_birth', $dependent->date_of_birth) }}"
                                        name="date_of_birth">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Update</button>
                            <a href="{{ route('dependents.index') }}" class="btn btn-light">Back to List</a>
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
