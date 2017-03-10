<?php

use Illuminate\Http\Request;
use App\Task;

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

/**
 * Display All Tasks
 */
Route::get('/task', function () {
    return [
        'success' => true,
        'data' => Task::orderBy('created_at', 'asc')->get()->all()
    ];
});

/**
 * Add A New Task
 */
Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->json()->all(), [
        'name' => 'required|max:255',
    ]);
    if ($validator->fails()) {
        return [
            'success' => false,
            'errors' => $validator->errors()->all()
        ];
    }
    $task = new Task;
    $task->name = $request->json('name');
    $task->save();
    return [
        'success' => true,
        'data' => []
    ];
});

/**
 * Update Task
 */
Route::put('/task/{id}', function ($id, Request $request) {
    $task = Task::findOrFail($id);
    $validator = Validator::make($request->json()->all(), [
        'name' => 'required|max:255',
    ]);
    if ($validator->fails()) {
        return [
            'success' => false,
            'errors' => $validator->errors()->all()
        ];
    }
    $task->name = $request->json('name');
    $task->save();
    return [
        'success' => true,
        'data' => []
    ];
});

/**
 * Delete An Existing Task
 */
Route::delete('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();
    return [
        'success' => true,
        'data' => []
    ];
});
