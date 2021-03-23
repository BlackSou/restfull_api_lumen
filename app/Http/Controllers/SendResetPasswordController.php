<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class SendResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->broker = 'users';
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(['success' => true]);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['success' => false]);
    }

    public function broker()
    {
        return Password::broker();
    }
}
