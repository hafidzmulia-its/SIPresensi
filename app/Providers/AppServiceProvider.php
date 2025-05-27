<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Extra;
use App\Models\ExtraRegistration;
use App\Models\AttendanceReport;
use App\Policies\ExtraPolicy;
use App\Policies\ExtraRegistrationPolicy;
use App\Policies\AttendanceReportPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    protected $policies = [
        'App\Models\Extra' => 'App\Policies\ExtraPolicy',
        'App\Models\ExtraRegistration' => 'App\Policies\ExtraRegistrationPolicy',
        // 'App\Models\AttendanceReport' => 'App\Policies\AttendanceReportPolicy',

    ];
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::policy(ExtraRegistration::class, ExtraRegistrationPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(AttendanceReport::class, AttendanceReportPolicy::class);
        // Register the policies for model authorization
    }
}
