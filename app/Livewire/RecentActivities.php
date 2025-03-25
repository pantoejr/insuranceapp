<?php

// app/Http/Livewire/RecentActivities.php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Activity;

class RecentActivities extends Component
{
    public $activities;
    public $loading = false;
    public $perPage = 5;
    public $pollInterval = 5; // Polling interval in seconds
    public $enablePolling = true; // Toggle for polling

    protected $listeners = ['activityLogged' => 'refreshActivities'];

    public function mount()
    {
        $this->loadActivities();
    }

    public function loadActivities()
    {
        $this->loading = true;
        $this->activities = $this->fetchActivities();
        $this->loading = false;
    }

    public function refreshActivities()
    {
        $this->activities = $this->fetchActivities();
    }

    protected function fetchActivities()
    {
        return Activity::with(['user', 'subject'])
            ->latest()
            ->take($this->perPage)
            ->get()
            ->map(function ($activity) {
                return [
                    'type' => $activity->type,
                    'icon' => $this->getIcon($activity->type),
                    'color' => $this->getColor($activity->type),
                    'description' => $activity->description,
                    'time' => $activity->created_at->diffForHumans(),
                    'subject' => $activity->subject,
                    'details' => $this->getDetails($activity),
                    'user' => $activity->user->name
                ];
            });
    }

    protected function getIcon($type)
    {
        return match ($type) {
            'policy_created' => 'bi-file-earmark-plus',
            'claim_approved' => 'bi-check-circle',
            'policy_expiring' => 'bi-exclamation-triangle',
            'policy_updated' => 'bi-pencil-square',
            default => 'bi-activity'
        };
    }

    protected function getColor($type)
    {
        return match ($type) {
            'policy_created' => 'primary',
            'claim_approved' => 'success',
            'policy_expiring' => 'warning',
            'policy_updated' => 'info',
            default => 'secondary'
        };
    }

    protected function getDetails($activity)
    {
        if (!$activity->subject) return null;

        return match ($activity->type) {
            'policy_created', 'policy_updated' => [
                'label' => 'Policy No.',
                'value' => $activity->subject->policy_number ?? 'N/A'
            ],
            'claim_approved' => [
                'label' => 'Claim Amount',
                'value' => isset($activity->subject->amount) ? '$' . number_format($activity->subject->amount, 2) : 'N/A'
            ],
            default => null
        };
    }

    public function render()
    {
        return view('livewire.recent-activities');
    }
}
