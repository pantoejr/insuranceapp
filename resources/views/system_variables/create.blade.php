@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('system-variables.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="name">Name</option>
                                <option value="sname">Sname</option>
                                <option value="email">Email</option>
                                <option value="address">Address</option>
                                <option value="phone">Phone</option>
                                <option value="mobile">Mobile</option>
                                <option value="logo">Logo</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="value" class="form-label">Value</label>
                            <input type="text" name="value" id="value" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('system-variables.index') }}" class="btn btn-light">Back To List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#type').change(function() {
                if ($(this).val() == 'logo') {
                    $('#value').attr('type', 'file');
                } else {
                    $('#value').attr('type', 'text');
                }
            });
        });
    </script>
@endsection
