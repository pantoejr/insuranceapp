<?php

namespace App\Providers;

use App\Services\EmailConfigurationService;
use App\Services\EmailService;
use App\Services\EmailServiceInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Email;

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
        //
    }
}
