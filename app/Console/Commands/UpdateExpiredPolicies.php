<?php

namespace App\Console\Commands;

use App\Models\PolicyAssignment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiredPolicies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policies:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::now();
        
        // Update policies that have expired
        PolicyAssignment::where('policy_duration_end', '<', $currentDate)
            ->where('is_expired', false)
            ->update(['is_expired' => true]);

        $this->info('Expired policies updated successfully.');
    }
}
