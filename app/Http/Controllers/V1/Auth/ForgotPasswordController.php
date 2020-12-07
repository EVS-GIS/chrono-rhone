<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function sendResetLinkEmail()
	{
		$this->validateEmail(request());

		$response = $this->broker()->sendResetLink(
			request()->only('email')
		);

		if ($response == Password::RESET_LINK_SENT) {
			return response()->json([
				'alert' => true,
				'alert_message' => 'Password reset link emailed!',
			]);
		}
		else {
			return response()->json(['email' => trans($response)], 422);
		}
	}
}