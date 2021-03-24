<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/sign-in",
     *     tags={"User"},
     *     summary="Login user into system",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="The user email for login",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid email/password supplied"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];
        $customMessages = [
            'required' => ':attribute cannot be empty'
        ];
        $this->validate($request, $rules, $customMessages);
        $email    = $request->input('email');
        try {
            $login = User::where('email', $email)->first();
            if ($login) {
                if ($login->count() > 0) {
                    if (Hash::check($request->input('password'), $login->password)) {
                        try {
                            $api_token = sha1($login->id.time());

                            $create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);
                            $message['status'] = true;
                            $message['message'] = 'Success login';
                            $message['data'] =  $login;
                            $message['api_token'] =  $api_token;

                            return response($message, 200);

                        } catch (QueryException $qe) {
                            $message['status'] = false;
                            $message['message'] = $qe->getMessage();
                            return response($message, 500);
                        }
                    } else {
                        $message['success'] = false;
                        $message['message'] = 'First name / Last name / email / password not found';
                        return response($message, 401);
                    }
                } else {
                    $message['success'] = false;
                    $message['message'] = 'First name / Last name / email / password  not found';
                    return response($message, 401);
                }
            } else {
                $message['success'] = false;
                $message['message'] = 'First name / Last name / email / password not found';
                return response($message, 401);
            }
        } catch (QueryException $qe) {
            $message['success'] = false;
            $message['message'] = $qe->getMessage();
            return response($message, 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"User"},
     *     summary="Registration user into system",
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="First name for new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="Last name for new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email for new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password for new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Phone for new user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid email/password supplied"
     *     )
     * )
     */
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
