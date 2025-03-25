<!-- resources/views/livewire/recent-activities.blade.php -->
<div @if ($enablePolling) wire:poll.{{ $pollInterval }}s="loadActivities" @endif>
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Recent Activities</h5>
            <div class="d-flex align-items-center">
                @if ($enablePolling)
                    <span class="badge bg-light text-dark me-2">
                        Auto-refresh: {{ $pollInterval }}s
                    </span>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            @if ($loading)
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @forelse($activities as $activity)
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-{{ $activity['color'] }}-opacity-10 p-2 rounded-2 me-3">
                                        <i class="bi {{ $activity['icon'] }} fs-5 text-{{ $activity['color'] }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 fw-medium">{{ $activity['description'] }}</p>
                                        <small class="text-muted">{{ $activity['time'] }}</small>
                                    </div>
                                    @if ($activity['details'])
                                        <p class="mb-0 text-muted small">
                                            {{ $activity['details']['label'] }}: {{ $activity['details']['value'] }}
                                        </p>
                                    @endif
                                    @if (isset($activity['user']))
                                        <p class="mb-0 text-muted small">
                                            By: {{ $activity['user'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item border-0 px-4 py-3 text-center text-muted">
                            No recent activities found
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>
