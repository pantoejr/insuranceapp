<?php

namespace App\Providers;

use App\Events\PolicyAssignmentSubmitted;
use App\Listeners\NotifyInsurerAssignmentUsers;
use App\Models\Policy;
use App\Observers\PolicyObserver;
use App\Services\EmailConfigurationService;
use App\Services\EmailService;
use App\Services\EmailServiceInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Email;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Policy::observe(PolicyObserver::class);
    }
}
