<?php

namespace App\Listeners;

use App\Events\PolicyAssignmentSubmitted;
use App\Models\InsurerAssignment;
use App\Notifications\PolicyAssignmentSubmittedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyInsurerAssignmentUsers
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PolicyAssignmentSubmitted $event)
    {
        // Fetch users associated with the insurer in the InsurerAssignment table
        $insurerAssignments = InsurerAssignment::where('insurer_id', $event->policyAssignment->insurer_id)
            ->with('user')
            ->get();

        // Notify each user
        foreach ($insurerAssignments as $assignment) {
            $assignment->user->notify(new PolicyAssignmentSubmittedNotification($event->policyAssignment));
        }
    }
}
