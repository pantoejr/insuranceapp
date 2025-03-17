<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <div class="card-title" id="policy-header" style="cursor: pointer;">{{ $model->full_name }} Policies</div>
                <div class="card-tools">
                    <a href="{{ route('client-policies.create', ['client' => $model]) }}" class="btn btn-primary"><i
                            class="bi bi-plus-circle"></i></a>
                </div>
            </div>
            <div class="card-body" id="policy-body">
                <div class="table-responsive">
                    <table class="table dataTable nowrap">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Policy</td>
                                <td>Insurer</td>
                                <td>Assigned By</td>
                                <td>Status</td>
                                <td>Action(s)</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
