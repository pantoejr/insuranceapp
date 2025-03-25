<?php

namespace App\Observers;

use App\Helpers\ActivityHelper;
use App\Models\Policy;

class PolicyObserver
{
    /**
     * Handle the Policy "created" event.
     */
    public function created(Policy $policy): void
    {
        ActivityHelper::log('policy_created', $policy);
    }

    /**
     * Handle the Policy "updated" event.
     */
    public function updated(Policy $policy): void
    {
        ActivityHelper::log('policy_updated', $policy);
    }

    /**
     * Handle the Policy "deleted" event.
     */
    public function deleted(Policy $policy): void
    {
        ActivityHelper::log('policy_deleted', $policy);
    }

    /**
     * Handle the Policy "restored" event.
     */
    public function restored(Policy $policy): void
    {
        //
    }

    /**
     * Handle the Policy "force deleted" event.
     */
    public function forceDeleted(Policy $policy): void
    {
        //
    }
}
