@extends('layouts.app')
@section('content')
    <div class="container-fluid py-2">
        <h4 class="mb-4">Dashboard</h4>
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="small-box text-bg-primary h-100">
                    <div class="inner">
                        <h3>{{ $clientCount = \App\Models\Client::count() }}</h3>
                        <p>Total Clients</p>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar bg-white bg-opacity-75" role="progressbar"
                                style="width: {{ min(100, ($clientCount / 500) * 100) }}%"
                                aria-valuenow="{{ round(($clientCount / 500) * 100) }}" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        <small class="d-block mt-1">{{ round(($clientCount / 500) * 100) }}% of annual target</small>
                    </div>
                    <i class="small-box-icon bi bi-people-fill"></i>
                    <a href="{{ route('clients.index') }}"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        View all <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
            <!-- Insurer Card -->
            <div class="col-md-4">
                <div class="small-box text-bg-danger h-100">
                    <div class="inner">
                        <h3>{{ $insurersCount = \App\Models\Insurer::count() }}</h3>
                        <p>Insurance Providers</p>
                        <div class="mt-2">
                            <span class="badge bg-white text-dark">Active: {{ $activeInsurers }}</span>
                        </div>
                    </div>
                    <i class="small-box-icon bi bi-shield-check"></i>
                    <a href="{{ route('insurers.index') }}"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        View all <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>

            <!-- Policy Card -->
            <div class="col-md-4">
                <div class="small-box text-bg-success h-100">
                    <div class="inner">
                        <h3>{{ $policyCount = \App\Models\Policy::count() }}</h3>
                        <p>Active Policies</p>
                        <div class="mt-2">
                            <span class="badge bg-white text-dark">{{ $renewalsDue }} renewals due</span>
                        </div>
                        <small class="d-block mt-1">this month</small>
                    </div>
                    <i class="small-box-icon bi bi-file-earmark-text"></i>
                    <a href="{{ route('policies.index') }}"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        View all <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-6">
                <!-- Policy Analytics -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                        <h5 class="mb-0">Policy Distribution</h5>

                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="policyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                @livewire('recent-activities')
            </div>

            <!-- Right Column -->
            <div class="col-lg-6">
                <!-- Claims Overview -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Claims Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="claimsChart"></canvas>
                        </div>
                        <div class="row text-center mt-3">
                            <div class="col-3">
                                <h4 class="text-secondary mb-0">{{ $processedClaims }}</h4>
                                <small class="text-muted">Processed</small>
                            </div>
                            <div class="col-3">
                                <h4 class="text-primary mb-0">{{ $pendingClaims }}</h4>
                                <small class="text-muted">Pending</small>
                            </div>
                            <div class="col-3">
                                <h4 class="text-success mb-0">{{ $approvedClaims }}</h4>
                                <small class="text-muted">Approved</small>
                            </div>
                            <div class="col-3">
                                <h4 class="text-danger mb-0">{{ $rejectedClaims }}</h4>
                                <small class="text-muted">Rejected</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('policies.create') }}"
                                class="btn btn-primary d-flex align-items-center justify-content-start">
                                <i class="bi bi-plus-circle me-2"></i> Add New Policy
                            </a>
                            <a href="{{ route('clients.create') }}"
                                class="btn btn-outline-primary d-flex align-items-center justify-content-start">
                                <i class="bi bi-person-plus me-2"></i> Register Client
                            </a>
                            <a href="{{ route('insurers.create') }}"
                                class="btn btn-outline-success d-flex align-items-center justify-content-start">
                                <i class="bi bi-building-add me-2"></i> Add Insurer
                            </a>
                            <a href="#" class="btn btn-outline-info d-flex align-items-center justify-content-start">
                                <i class="bi bi-file-earmark-text me-2"></i> Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Implementation -->
    <script type="text/javascript">
        const policyCtx = document.getElementById('policyChart').getContext('2d');
        const policyChart = new Chart(policyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Policies',
                    data: @json(array_values($monthlyPolicies)),
                    backgroundColor: '#4e73df',
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Claims Chart
        const claimsCtx = document.getElementById('claimsChart').getContext('2d');
        const claimsChart = new Chart(claimsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Processed', 'Pending', 'Approved', 'Rejected'],
                datasets: [{
                    data: [{{ $processedClaims }}, {{ $pendingClaims }}, {{ $approvedClaims }}, {{ $rejectedClaims }}],
                    backgroundColor: ['#000000', '#4e73df', '#1cc88a', '#e74a3b'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '70%',
            },
        });
    </script>
@endsection
