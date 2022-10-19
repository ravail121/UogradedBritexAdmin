<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\BusinessVerificationApproved' => [
            'App\Listeners\SendApprovalEmail',
        ],
        'App\Events\BusinessVerificationRejected' => [
            'App\Listeners\SendRejectionEmail',
        ],
        'App\Events\PortingComplete' => [
            'App\Listeners\SendPortingCompleteEmail',
        ],
        'App\Events\RejectPort' => [
            'App\Listeners\SendPortRejectEmail',
        ],
        'App\Events\ComposeEmail' => [
            'App\Listeners\SendComposedEmail',
        ],
        'App\Events\SubcriptionStatusChanged' => [
            'App\Listeners\SendEmailForChangedSubcriptionStatus'
        ],
        'App\Events\CustomInvoiceAdded' => [
            'App\Listeners\SendCustomInvoiceEmail'
        ],
        'App\Events\InvoiceEmail' => [
            'App\Listeners\SendEmailWithInvoice'
        ],
        'App\Events\ShippingNumber' => [
            'App\Listeners\SendMailForShippingNumber'
        ],
        'App\Events\InstantInvoiceAdded' => [
	        'App\Listeners\SendInstantInvoiceEmail'
        ],
        'App\Events\SubscriptionForReactivation' => [
	        'App\Listeners\SendEmailForSubscriptionForReactivation'
        ],
        'App\Events\SubscriptionRequestedZipRemoved' => [
	        'App\Listeners\SendEmailForSubscriptionRequestedZipRemoved'
		],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
