<?php

namespace App\Http\Controllers\Auth\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;

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

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed.api')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *Overriden
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * Overriden
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            return response()->json([
                'error' => 'Unauthorized! ID mismatch'
            ], 401);
        }

        if (! hash_equals((string) $request->query('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json([
                'error' => 'Unauthorized! Hash mismatch'
            ], 401);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'error' => 'User email already verified!'
            ], 401);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'message' => 'User email address verified successfully!'
        ], 401);
    }

    /**
     * Resend the email verification notification.
     *
     * Overriden
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'error' => 'User email has already been verfied!'
            ], 401);
        }

        $request->user()->sendEmailVerificationNotification();
        
        return response()->json([
            'message'   => 'Verification email resent successfully!'
        ]);
    }
}
