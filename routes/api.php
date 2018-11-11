<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/categoria', 'Api\CategoriaController', [
    'parameters' => [
        'categoria' => 'categoria'
    ]
]);

Route::apiResource('/proceso', 'Api\ProcesoController', [
    'parameters' => [
        'proceso' => 'proceso'
    ]
]);

Route::apiResource('/responsable', 'Api\ResponsableController', [
    'parameters' => [
        'responsable' => 'responsable'
    ]
]);
