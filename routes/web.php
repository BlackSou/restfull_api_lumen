<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->post('register', 'UserController@register');
    $router->post('sign-in', 'UserController@login');

    $router->post('recover-password', 'SendResetPasswordController@sendResetLinkEmail');
    $router->post('recover-password/reset', [ 'as' => 'password.reset', 'uses' => 'ResetPasswordController@reset' ]);


    $router->group([
        'prefix' => 'user/{id}/',
        'middleware' => ['auth']],
        function () use ($router) {
            $router->post('companies', 'CompanyController@addCompany');
            $router->get('companies', 'CompanyController@getCompany');
        });
});

