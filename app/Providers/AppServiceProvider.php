<?php

namespace App\Providers;

use App\Notifications\DynamicSmtpMailChannel;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MailChannel::class,
            DynamicSmtpMailChannel::class
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        config(['auth.defaults.guard' => 'staff']);

        View::composer(
            'layouts.partials._sidebar', 'App\Http\Controllers\BusinessVerificationController'
        );
    }
}
