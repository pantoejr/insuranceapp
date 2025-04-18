@can('view-attachments')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header">
                    <div class="card-title" id="attachment-header" style="cursor: pointer;">{{ $model->full_name }}
                        Attachments</div>
                    <div class="card-tools">
                        @can('add-client-attachment')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addAttachmentModal">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                            <div class="modal" id="addAttachmentModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Attachment</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <form id="addAttachmentForm" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="client_id" value="{{ $model->id }}">
                                                <div class="form-group mb-3">
                                                    <label for="file_name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="file_name" name="file_name"
                                                        placeholder="Attachment Name" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="file_path" class="form-label">File</label>
                                                    <input type="file" class="form-control" id="file_path" name="file_path"
                                                        required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <button type="submit" class="btn btn-success">Add Attachment</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <div id="loading" class="spinner-border text-primary" role="status"
                                                        style="display: none;">
                                                        <span class="sr-only"></span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body" id="attachment-body">
                    <div class="table-responsive">
                        <table class="table dataTable nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>File Name</th>
                                    <th>File Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model->attachments as $attachment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attachment->file_name }}</td>
                                        <td>{{ $attachment->file_type }}</td>
                                        <td>
                                            @can('edit-client-attachment')
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                                            @endcan
                                            @can('delete-attachment')
                                                <form
                                                    action="{{ route('attachments.destroy', ['id' => $attachment->id, 'clientId' => $model->id]) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="bi bi-trash"></i></button>
                                                </form>
                                            @endcan

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#addAttachmentForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $('#loading').show();

                $.ajax({
                    url: '{{ route('clients.addAttachment', $model->id) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#loading').hide();
                        if (response.flag === 'success') {
                            alert(response.msg);
                            location.reload();
                        } else {
                            alert(response.msg);
                        }
                    },
                    error: function(response) {
                        $('#loading').hide();
                        alert('An error occurred while adding the attachment.');
                    }
                });
            });
        });
    </script>

@endcan
