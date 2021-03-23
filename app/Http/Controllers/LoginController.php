<?php
namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
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
}
