<?php

namespace App\Console\Commands;

use App\Helpers\SmsHelper;
use App\Models\PolicyAssignment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPolicyExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:policy-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check client policies and email clients if the policy is one month to expiry';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {

        $policies = PolicyAssignment::where('policy_duration_end', '<=', Carbon::now()->addMonth())
            ->where('policy_duration_end', '>', Carbon::now()->subMonths(1))
            ->get();

        foreach ($policies as $policy) {
            $client = $policy->client;

            // Parse the policy_duration_end as Carbon before calling isPast()
            $policyEndDate = Carbon::parse($policy->policy_duration_end);
            $isExpired = $policyEndDate->isPast();

            $message = 'Dear ' . $client->fullname . ', We would like to inform you that your policy ' . $policy->policyType->name .
                ($isExpired ? ' expired on ' : ' is set to expire on ') .
                $policyEndDate->format('d M Y') . '.';

            SmsHelper::sendSms($client->phone, $message);

            Mail::send('emails.policy_expiry', compact('client', 'policy', 'isExpired'), function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('Policy Expiry Notification');
            });
        }

        return 0;
    }
}
