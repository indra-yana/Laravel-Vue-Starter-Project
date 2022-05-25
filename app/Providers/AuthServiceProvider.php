<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Build and return custom verification URL
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $verifyFEUrl = url('auth/email/verify/confirm'); 
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return $verifyFEUrl ? $verifyFEUrl .'?verify_url=' .urlencode($verifyUrl) : $verifyUrl;
        });

        // Build and return custom password reset URL
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return url("auth/password/reset", [
                "token" => $token,
                "email" => $notifiable->getEmailForPasswordReset(),
            ]);
        });
    }
}
