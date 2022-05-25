<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails {
        verify as protected parentVerify;
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : redirect('auth/email/verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->verified($request);
        }

        $this->parentVerify($request);
        if ($response = $this->verified($request)) {
            return $response;
        }
    }

    /**
     * Check if the user has been verified or not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function checkIfHasVerified(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->verified($request);
        }

        return $request->wantsJson()
                        ? new JsonResponse(["message" => __("Your account not verified"), "data" => ["hasVerifiedEmail" => false]], 200)
                        : redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * The user has been verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        return $request->wantsJson()
                        ? new JsonResponse(["message" => __("Already verified"), "data" => ["hasVerifiedEmail" => true, "email_verified_at" => $request->user()->email_verified_at]], 200)
                        : redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->verified($request);
        }

        $request->user()->sendEmailVerificationNotification();

        return $request->wantsJson()
                    ? new JsonResponse(["message" => __("A fresh verification link has been sent to your account"), "data" => ["hasVerifiedEmail" => false]], 200)
                    : back()->with('resent', true);
    }
}
