<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/user/{id}/companies",
     *     tags={"User company"},
     *     summary="Add company for user",
     *     operationId="UserById",
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="api_token",
     *         in="query",
     *         description="Api token can be obtained by login",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Title company",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Phone company",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Description company",
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

    /**
     * @OA\Get(
     *     path="/api/user/{id}/companies",
     *     operationId="UserById",
     *     tags={"User company"},
     *     summary="Get user company",
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="api_token",
     *         in="query",
     *         description="Api token can be obtained by login",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
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
