<?php

use App\Console\Commands\BirthdayAlerts;
use App\Console\Commands\CheckPolicyExpiry;
use App\Console\Commands\UpdateExpiredPolicies;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(CheckPolicyExpiry::class)->everyMinute();
Schedule::command(BirthdayAlerts::class)->daily();
Schedule::command(UpdateExpiredPolicies::class)->daily();
