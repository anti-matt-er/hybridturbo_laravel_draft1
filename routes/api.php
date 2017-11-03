<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/editable/{model}', function ($model) {
	$model = "App\\Models\\" . ucfirst($model);
	$model = new $model;
	if (isset($model->editable) && !empty($model->editable)) {
		return $model->editable;
	}
	return $model->getFillable();
});

Route::get('/country', function () {
	return config('app.country');
});

Route::get('/format/{model}/{field}/{raw}', function ($model, $field, $raw) {
	$object = "App\\Models\\" . ucfirst($model);
	return knockout_formatter(new $object, $field, $raw);
});
