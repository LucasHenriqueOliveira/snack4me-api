<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;

//general routes
$api->post('auth/authorize', [
    'uses' => AuthenticationController::class . '@authenticate',
    'as' => 'sign_in'
]);
$api->get('/auth/facebook', [
    'uses' => AuthenticationController::class . '@facebook',
    'as' => 'sign_in_facebook'
]);
$api->get('/auth/facebook/callback', [
    'uses' => AuthenticationController::class . '@facebookCallback',
    'as' => 'sign_in_facebook'
]);

$api->group(['middleware' => 'api.auth',  'prefix' => 'auth'], function () use ($api) {
    $api->get('/logout', [
        'uses' => AuthenticationController::class . '@logout'
    ]);
    $api->get('/refresh', [
        'uses' => AuthenticationController::class . '@refresh'
    ]);
    $api->get('/payload', [
        'uses' => AuthenticationController::class . '@payload'
    ]);

});

$api->group(['middleware' => 'api.auth',  'prefix' => 'user'], function () use ($api) {
    $api->get('/{id}', [
        'uses' => UserController::class . '@get'
    ]);
    $api->post('/', [
        'uses' => UserController::class . '@post'
    ]);
    $api->put('/{id}', [
        'uses' => UserController::class . '@put'
    ]);
    $api->delete('/{id}', [
        'uses' => UserController::class . '@delete'
    ]);

});

$api->group(['middleware' => 'api.auth',  'prefix' => 'profile'], function () use ($api) {
    $api->get('/{id}', [
        'uses' => ProfileController::class . '@get'
    ]);
    $api->post('/', [
        'uses' => ProfileController::class . '@post'
    ]);
    $api->put('/{id}', [
        'uses' => ProfileController::class . '@put'
    ]);
    $api->delete('/{id}', [
        'uses' => ProfileController::class . '@delete'
    ]);
});

$api->group(['middleware' => 'api.auth',  'prefix' => 'event'], function () use ($api) {
    $api->get('/', [
        'uses' => EventController::class . '@getAll'
    ]);
    $api->get('/{id}', [
        'uses' => EventController::class . '@get'
    ]);
    $api->post('/', [
        'uses' => EventController::class . '@post'
    ]);
    $api->put('/{id}', [
        'uses' => EventController::class . '@put'
    ]);
    $api->delete('/{id}', [
        'uses' => EventController::class . '@delete'
    ]);
});


$api->get('/', function () use ($app) {
    return response()->json([
        "Project Name" => env("APP_NAME"),
        "API version" => env("API_VERSION"),
        "Lumen" => $app->version(),
        "PHP" => phpversion()
    ]);
});