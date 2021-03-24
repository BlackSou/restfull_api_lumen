<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="RESTFull API Lumen",
     *      description="RESTFull API SwaggerOpenApi description.",
     *      @OA\Contact(
     *          email="itv.develop@gmail.com"
     *      )
     * )
     * @OA\Tag(
     *     name="RESTFull API",
     *     description="API Endpoints to share the company's information for the logged users"
     * )
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        return response(["success" => false, "message" => $errors], 401);
    }
}
