<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\JobPosting;
use App\Policies\ApplicationPolicy;
use App\Policies\JobPostingPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Application::class, ApplicationPolicy::class);
        Gate::policy(JobPosting::class, JobPostingPolicy::class);
    }
}
