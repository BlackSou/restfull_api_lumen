<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ];

        $customMessages = [
            'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);

        try {
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $password = app('hash')->make($request->input('password'));

            User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'password' => $password,
                'api_token' => ""
            ]);
            $message['status'] = true;
            $message['message'] = 'Registration success!';
            return response($message, 200);
        } catch (QueryException $qe) {
            $message['status'] = false;
            $message['message'] = $qe->getMessage();
            return response($message, 500);
        }
    }
}
