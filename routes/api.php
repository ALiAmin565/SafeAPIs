<?php

use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\videoController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\All_UserController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\ChatAdviceController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\RecommendationController;

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



Route::group([

    'middleware' => 'api',



], function ($router) {
    Route::post('create', [AuthController::class, 'create']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('checkOtp', [AuthController::class, 'checkOtp']);
    Route::post('sendOtp', [AuthController::class, 'sendOtp']);
    Route::post('resendOtp', [AuthController::class, 'reSendOtp']);
    Route::post('resetPassword', [AuthController::class, 'resetPassword']);
    Route::post('dymnamikeLink', [AuthController::class, 'dymnamikeLink']);
});

// for videos

Route::resource('video', videoController::class);
Route::resource('posts', PostController::class);
Route::apiResource('plan', PlanController::class);

Route::apiResource('Recommendation', RecommendationController::class);
Route::resource('archive', ArchiveController::class);

Route::apiResource('User', All_UserController::class);
Route::get('get_user/{id}', [All_UserController::class, 'get_user'])->name('get_user');
Route::get('search/{id}', [All_UserController::class, 'serach'])->name('serach');
Route::get('get_all_subscrib/{id}', [All_UserController::class, 'get_all_subscrib']);

Route::resource('telegram', TelegramController::class);

// Chat Advice
Route::get('ChatAdvice', [ChatAdviceController::class, 'getChat']);
Route::post('ChatAdvice_store', [ChatAdviceController::class, 'store']);

Route::apiResource('coupons', CouponController::class);
Route::apiResource('payment', PaymentController::class);
Route::apiResource('post', PostController::class);



// for pending

Route::get('pending',[PayController::class,'pending']);
Route::post('ActivePending',[PayController::class,'ActivePending']);





//  for Front








Route::prefix('Front')->group(function () {

    Route::get('/', [FrontController::class, 'getPlan']);

    Route::post('SelectPlan', [FrontController::class, 'SelectPlan']);
    Route::post('Recommindation', [FrontController::class, 'Recommindation']);
});
