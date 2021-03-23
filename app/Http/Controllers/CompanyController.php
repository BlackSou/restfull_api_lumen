<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function addCompany(Request $request)
    {
        $rules = [
            'title' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ];

        $customMessages = [
            'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);

        try {
            $user_id = $request->id;
            $title= $request->input('title');
            $phone = $request->input('phone');
            $description = $request->input('description');

            Company::create([
                'user_id' => $user_id,
                'title' => $title,
                'phone' => $phone,
                'description' => $description,
            ]);
            $message['status'] = true;
            $message['message'] = 'Company added successfully!';
            return response($message, 200);
        } catch (QueryException $qe) {
            $message['status'] = false;
            $message['message'] = $qe->getMessage();
            return response($message, 500);
        }
    }

    public function getCompany($id)
    {
        $user_companies = User::find($id)->companies;
        if ($user_companies) {
            $message['status'] = true;
            $message['message'] = $user_companies;

            return response($message);
        } else {
            $message['status'] = false;
            $message['message'] = 'Cannot find user!';

            return response($message);
        }
    }
}
