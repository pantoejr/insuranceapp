<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Insurance System | {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Classic Technovations Inc." />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/overlayscrollbars.min.css') }}" />
    <link href="{{ asset('css/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/jsvectormap.min.css') }}" />
    <script src="{{ asset('js/jquery.js') }}"></script>
    @livewireStyles
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="{{ route('app.index') }}" class="nav-link">Insurance
                            App</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @include('partials.profile')
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="./index.html" class="brand-link">
                    {{-- <img src="../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" /> --}}
                    <span class="brand-text fw-light">Insurance App</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('app.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>
                                    User Management
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-person-fill"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-gear-fill"></i>
                                        <p>
                                            Roles
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('permissions.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-person-gear"></i>
                                        <p>
                                            Permissions
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-gear-fill"></i>
                                <p>
                                    System Settings
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('email-settings.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-envelope-fill"></i>
                                        <p>Emails</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-phone-fill"></i>
                                        <p>
                                            SMS
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-person-fill"></i>
                                <p>
                                    Client Management
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('clients.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-people-fill"></i>
                                        <p>Clients</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('employees.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-people-fill"></i>
                                        <p>
                                            Employees
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dependents.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-people-fill"></i>
                                        <p>
                                            Dependents
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('attachments.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-folder-fill"></i>
                                        <p>
                                            Attachments
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-menu-button-wide-fill"></i>
                                <p>
                                    Insurance
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('insurers.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-people-fill"></i>
                                        <p>Insurer</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('insurer-assignments.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-people-fill"></i>
                                        <p>
                                            Assign Users
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-journals"></i>
                                <p>
                                    Policy Management
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('clients.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-journal-text"></i>
                                        <p>Policies</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('employees.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-people-fill"></i>
                                        <p>
                                            Assign Policies
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
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
            <div class="float-end d-none d-sm-inline">{{ env('APP_NAME') }}</div>
            <strong>
                Copyright &copy; {{ date('Y') }}
                <a href="https:://clatech.io" class="text-decoration-none">Classic Technovations Inc.</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>
    <script src="{{ asset('js/dataTables.js') }}"></script>
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
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('js/world.js') }}"></script>
    @livewireScripts
</body>

</html>
