<?php

namespace App\Console\Commands;

use App\Helpers\SmsHelper;
use Illuminate\Console\Command;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BirthdayAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks clients for individual clients who birthday is on its way';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('m-d');

        $clients = Client::where('client_type', 'individual')
            ->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = ?', [$today])
            ->get();

        if ($clients->isEmpty()) {
            $this->info('No clients have birthdays today.');
        } else {
            foreach ($clients as $client) {
                SmsHelper::sendSms($client->phone, "Happy Birthday, $client->full_name! 🎉 Wishing you a joyful day. We're grateful to have you as our client!");
                Mail::send('emails.birthday_alert', compact('client'), function ($message) use ($client) {
                    $message->to($client->email)
                        ->subject('Birthday Greetings');
                });
                $this->info("Client: $client->full_name, Birthday: $client->date_of_birth");
            }
        }
    }
}
