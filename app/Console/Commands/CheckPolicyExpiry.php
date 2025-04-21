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
            ->where('policy_duration_end', '>', Carbon::now())
            ->get();

        foreach ($policies as $policy) {
            $client = $policy->client;
            SmsHelper::sendSms($client->phone, 'Dear ' . $client->fullname . ', We would like to inform you that your policy ' .  $policy->policy_name  . ' is set to expire on ' .
                $policy->policy_duration_end);
            Mail::send('emails.policy_expiry', compact('client', 'policy'), function ($message) use ($client) {
                $message->to($client->email)
                    ->subject('Policy Expiry Notification');
            });
            $this->info('Email sent to ' . $client->email);
        }

        return 0;
    }
}
