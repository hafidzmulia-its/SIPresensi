<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Register your model→policy mappings here:
        \App\Models\Extra::class => \App\Policies\ExtraPolicy::class,
        \App\Models\ExtraRegistration::class => \App\Policies\ExtraRegistrationPolicy::class,
        \App\Models\AttendanceReport::class => \App\Policies\AttendanceReportPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
