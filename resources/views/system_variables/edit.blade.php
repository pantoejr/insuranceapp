@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4" style="border:none;">
                <div class="card-header" style="border:none;">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('system-variables.update', ['id' => $systemVariable->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $systemVariable->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="name" {{ $systemVariable->type == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="sname" {{ $systemVariable->type == 'sname' ? 'selected' : '' }}>Sname
                                </option>
                                <option value="email" {{ $systemVariable->type == 'email' ? 'selected' : '' }}>Email
                                </option>
                                <option value="address" {{ $systemVariable->type == 'address' ? 'selected' : '' }}>Address
                                </option>
                                <option value="phone" {{ $systemVariable->type == 'phone' ? 'selected' : '' }}>Phone
                                </option>
                                <option value="mobile" {{ $systemVariable->type == 'mobile' ? 'selected' : '' }}>Mobile
                                </option>
                                <option value="logo" {{ $systemVariable->type == 'logo' ? 'selected' : '' }}>Logo</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="value" class="form-label">Value</label>
                            <input type="{{ $systemVariable->type == 'logo' ? 'file' : 'text' }}" name="value"
                                id="value" class="form-control"
                                value="{{ $systemVariable->type == 'logo' ? '' : $systemVariable->value }}"
                                {{ $systemVariable->type == 'logo' ? '' : 'required' }}>
                            @if ($systemVariable->type == 'logo' && $systemVariable->value)
                                <img id="logo-preview" src="{{ asset('storage/' . $systemVariable->value) }}"
                                    alt="Logo Preview" style="max-width: 200px; margin-top: 10px;">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('system-variables.index') }}" class="btn btn-light">Back to List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#type').change(function() {
                if ($(this).val() == 'logo') {
                    $('#value').attr('type', 'file').val('');
                    $('#logo-preview').show();
                } else {
                    $('#value').attr('type', 'text').val('{{ $systemVariable->value }}');
                    $('#logo-preview').hide();
                }
            });

            $('#value').change(function() {
                if ($('#type').val() == 'logo') {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#logo-preview').attr('src', e.target.result).show();
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });
        });
    </script>
@endsection
