<!doctype html>
<html lang="en">
@php
    $logo = \App\Models\SystemVariable::where('type', 'logo')->first();
    $name = \App\Models\SystemVariable::where('type', 'name')->first();
    $sname = \App\Models\SystemVariable::where('type', 'sname')->first();
@endphp

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @if (isset($title))
        <title>{{ env('APP_NAME') }} | {{ $title }}</title>
    @else
        <title>{{ env('APP_NAME') }} | Error </title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Classic Technovations Inc." />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/overlayscrollbars.min.css') }}" />
    <link href="{{ asset('css/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/jsvectormap.min.css') }}" />
    <script src="{{ asset('js/jquery.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <script src="{{ asset('js/chart.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    @livewireStyles
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body" style="border:none;">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="{{ route('app.index') }}" class="nav-link">
                            @if ($name)
                                {{ $name->value }}
                            @else
                                Insurance App
                            @endif
                        </a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @include('partials.profile')
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar shadow" data-bs-theme="dark" style="background-color: #00005f;">
            <div class="sidebar-brand" style="background-color: #00004f; border:none;">
                @if ($logo)
                    <a href="{{ route('app.index') }}" class="brand-link">
                        <img src="{{ asset('storage/' . $logo->value) }}" alt="System Logo" class="brand-image " />
                        <span class="brand-text fw-light">
                            @if ($sname)
                                {{ $sname->value }}
                            @else
                                Insurance App
                            @endif
                        </span>
                    </a>
                @else
                    <a href="{{ route('app.index') }}" class="brand-link">
                        <span class="brand-text fw-light">Insurance App</span>
                    </a>
                @endif
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        @can('dashboard')
                            <li class="nav-item">
                                <a href="{{ route('app.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-speedometer"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('clients')
                            <li class="nav-item">
                                <a href="{{ route('clients.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>Clients</p>
                                </a>
                            </li>
                        @endcan
                        @can('insurers')
                            <li class="nav-item">
                                <a href="{{ route('insurers.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>Insurers</p>
                                </a>
                            </li>
                        @endcan
                        @can('policies')
                            <li class="nav-item">
                                <a href="{{ route('policies.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-journal-text"></i>
                                    <p>Policies</p>
                                </a>
                            </li>
                        @endcan
                        @can('services')
                            <li class="nav-item">
                                <a href="{{ route('services.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-list-task"></i>
                                    <p>Services</p>
                                </a>
                            </li>
                        @endcan
                        @can('sales')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-currency-dollar"></i>
                                    <p>
                                        Sales
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-policies-assigned')
                                        <li class="nav-item">
                                            <a href="{{ route('assign-policy.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-journal"></i>
                                                <p>Assign Policy</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-invoices')
                                        <li class="nav-item">
                                            <a href="{{ route('invoices.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-receipt"></i>
                                                <p>Invoices</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-payments')
                                        <li class="nav-item">
                                            <a href="{{ route('payments.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-wallet-fill"></i>
                                                <p>
                                                    Payments
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('policy-configuration')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-gear-fill"></i>
                                    <p>
                                        Policy Configuration
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-policy-types')
                                        <li class="nav-item">
                                            <a href="{{ route('policy-types.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-journals"></i>
                                                <p>Policy Type</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-policy-sub-types')
                                        <li class="nav-item">
                                            <a href="{{ route('policySubTypes.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-journals"></i>
                                                <p>
                                                    Policy Sub Type
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('user-management')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>
                                        User Management
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-users')
                                        <li class="nav-item">
                                            <a href="{{ route('users.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-person-fill"></i>
                                                <p>Users</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-roles')
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-gear-fill"></i>
                                                <p>
                                                    Roles
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-permissions')
                                        <li class="nav-item">
                                            <a href="{{ route('permissions.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-person-gear"></i>
                                                <p>
                                                    Permissions
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('system-settings')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-gear-fill"></i>
                                    <p>
                                        System Settings
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-sms-logs')
                                        <li class="nav-item">
                                            <a href="{{ route('sms-logs.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-envelope-fill"></i>
                                                <p>SMS Logs</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-system-variables')
                                        <li class="nav-item">
                                            <a href="{{ route('system-variables.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-code-slash"></i>
                                                <p>
                                                    Variables
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('requests')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-book-fill"></i>
                                    <p>
                                        Reports
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-policies')
                                        <li class="nav-item">
                                            <a href="{{ route('reports.policies') }}" class="nav-link">
                                                <i class="nav-icon bi bi-card-text"></i>
                                                <p>Policies</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-claims')
                                        <li class="nav-item">
                                            <a href="{{ route('system-variables.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-journal-text"></i>
                                                <p>
                                                    Claims
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-services')
                                        <li class="nav-item">
                                            <a href="{{ route('system-variables.index') }}" class="nav-link">
                                                <i class="nav-icon bi bi-gear"></i>
                                                <p>
                                                    Services
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('backlogs')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-gear-fill"></i>
                                    <p>
                                        Backlogs
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-policies-assigned')
                                        <li class="nav-item">
                                            <a href="{{ route('backlog.policyAssignments') }}" class="nav-link">
                                                <i class="nav-icon bi bi-journal"></i>
                                                <p>Policy Assignments</p>
                                            </a>
                                        </li>
                                    @endcan                                    
                                </ul>
                            </li>
                        @endcan
                    </ul>
                </nav>
            </div>
        </aside>
        <main class="app-main">
            <div class="app-content">
                <div class="container-fluid pt-4">
                    @if (session('msg'))
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div class="toast align-items-center text-white bg-{{ session('flag') }} border-0"
                                role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        {{ session('msg') }}
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                        data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </main>
        <footer class="app-footer">
            <strong>
                Copyright &copy; {{ date('Y') }}
                <a href="https://safeinsurancebrokers.com/" class="text-decoration-none">Safe Insurance Brokers</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>
    @livewireScripts
    <script src="{{ asset('js/dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('js/overlayscrollbars.browser.es6.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script>
        $(document).ready(function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl)
            })
            toastList.forEach(toast => toast.show());

            $('.dataTable').DataTable();
        });
    </script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <script src="{{ asset('js/Sortable.min.js') }}"></script>
    <script>
        const connectedSortables = document.querySelectorAll('.connectedSortable');
        connectedSortables.forEach((connectedSortable) => {
            let sortable = new Sortable(connectedSortable, {
                group: 'shared',
                handle: '.card-header',
            });
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script>
    <script type="text/javascript">
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = event.currentTarget.href;
            }
            return false;
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-btn').on('click', function(event) {
                event.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();

                        // Swal.fire({
                        //     title: "Success",
                        //     text: "Record deleted successfully",
                        //     icon: "success",
                        // });
                        // location.reload();
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('js/world.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

</body>

</html>
