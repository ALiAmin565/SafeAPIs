<?php

use App\Events\recommend;
use App\Models\recommendation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {


    return view('welcome');
});

Route::get('telegrem',[RecommendationController::class,'update_telgrame']);


// Route::get('app',function(){

// $user=recommendation::find(38)->plan;

// return $user;


// });
