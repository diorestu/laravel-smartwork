<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Admin\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Auth API Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class,'logoutApi']);
// Route::post('logout', [UserController::class,'logoutApi']);

Route::middleware(['auth:api', 'is_admin'])->group(function () {
    Route::get('details', [AuthController::class, 'details']);
    Route::get('getCabang/{id}', function ($id) {
        $course = App\Models\User::select(['id', 'nama'])->where('id_cabang', $id)->where('roles', 'user')->get();
        return response()->json($course);
    });
});


