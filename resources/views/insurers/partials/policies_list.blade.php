<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm mb-4" style="border:none;">
            <div class="card-header" style="border:none;">
                <div class="card-title" id="policy-header" style="cursor: pointer;">Insurer Policies</div>
                <div class="card-tools">
                    <a href="{{ route('insurer-policies.create') }}" class="btn btn-primary"><i
                            class="bi bi-pencil-fill"></i></a>
                </div>
                @include('insurers.partials.edit_policy')
            </div>
            <div class="card-body" id="policy-body" style="display: none;">
                <div class="table-responsive">
                    <table class="table dataTable nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Insurer</th>
                                <th>Policy</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insurer->insurerPolicies as $insurerPolicy)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $insurerPolicy->insurer->company_name }}</td>
                                    <td>{{ $insurerPolicy->policy->name }}</td>
                                    <td>{{ ucfirst($insurerPolicy->status) }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-policy-btn" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-insurer-id="{{ $insurer->id }}"
                                            data-insurerPolicy-id="{{ $insurerPolicy->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="{{ route('insurer-policies.destroy', $insurerPolicy->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this insurer policy?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
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
        $('#policy-header').click(function() {
            $('#policy-body').toggle();
        });
    });
</script>
