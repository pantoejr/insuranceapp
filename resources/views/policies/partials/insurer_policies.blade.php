<div class="row">
    @include('policies.partials.assign_policy')
    <div class="col-md-12">
        <div class="card border-0 shadown-sm">
            <div class="card-header">
                <div class="card-title" id="policy-header" style="cursor: pointer;">Add Policy to Insurer</div>
                <div class="card-tools">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPolicyModal"><i
                            class="bi bi-plus-circle"></i></button>
                </div>
            </div>
            <div class="card-body" id="policy-body" style="display: none;">
                <div class="table-responsive">
                    <table class="table dataTable nowrap">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Policy</td>
                                <td>Insurer</td>
                                <td>Action(s)</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($policy->insurerPolicies as $insurerPolicy)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $insurerPolicy->policy->name }}</td>
                                    <td>{{ $insurerPolicy->insurer->company_name }}</td>
                                    <td>
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
