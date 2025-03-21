<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-bell-fill"></i>
        @if (auth()->user()->unreadNotifications->count() > 0)
            <span class="navbar-badge badge text-bg-warning">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">
            {{ auth()->user()->unreadNotifications->count() }} Notifications
        </span>
        <div class="dropdown-divider"></div>

        @forelse(auth()->user()->unreadNotifications as $notification)
            <button class="dropdown-item mark-as-read text-wrap" style="font-size: 13px;"
                data-notification-id="{{ $notification->id }}"
                data-redirect-url="{{ route('notifications.markAsRead') }}">
                @if ($notification->type === 'App\Notifications\PolicyAssignmentSubmittedNotification')
                    <i class="bi bi-envelope me-2"></i>
                    {{ $notification->data['message'] }}
                @else
                    <i class="bi bi-envelope me-2"></i>
                    {{ $notification->data['message'] ?? 'New notification' }}
                @endif
                <span class="float-end text-secondary fs-7" style="font-size: 13px;">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </button>
            <div class="dropdown-divider"></div>
        @empty
            <a href="#" class="dropdown-item">
                <i class="bi bi-info-circle me-2"></i>
                No new notifications
            </a>
        @endforelse
    </div>
</li>
