<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="user-image rounded-circle shadow-sm"
            alt="User Image" />
        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <li class="user-header text-bg-primary">
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="rounded-circle shadow" alt="User Image" />
            <p>{{ Auth::user()->name }}</p>
        </li>
        <li class="user-footer">
            <a href="{{ route('change-password') }}" class="btn btn-default btn-flat">Profile</a>
            <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end">Sign out</a>
        </li>
    </ul>
</li>
