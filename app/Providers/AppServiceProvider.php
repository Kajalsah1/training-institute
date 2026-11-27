<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\User;
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
        // Admin can manage any course; a user can manage only their own
        Gate::define('manage-course', function (User $user, Course $course) {
            return $user->role === 'admin'
                || $user->id === $course->user_id;
        });
    }
}
