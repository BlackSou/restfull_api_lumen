<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\User;
use Illuminate\Database\QueryException;

class Authenticate
{
    protected $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            if ($request->has('api_token')) {
                try {
                    $api_token = $request->input('api_token');
                    $check_token = User::where('api_token', $api_token)->first();
                    if (!$check_token) {
                        $message['status'] = false;
                        $message['message'] = 'Unauthorized';
                        return response($message, 401);
                    }
                } catch (QueryException $qx) {
                    $message['status'] = false;
                    $message['message'] = $qx->getMessage();
                    return response($message, 500);
                }
            } else {
                $message['status'] = false;
                $message['message'] = 'Login please!';
                return response($message, 401);
            }
        }
        return $next($request);
    }
}
