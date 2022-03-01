<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Api\gameController;
 use Laravel\Socialite\Facades\Socialite;
 use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

Route::get('/hello',function(){
    return "Hello World";
}); 


//if token is not provided in the request header, then return error
Route::group(['middleware' => ['auth:sanctum']], function () {
   
});

Route::get('/games/{id}',[gameController::class,'getGameInfo']);

Route::get('/trophies',[gameController::class,'getAllTrophies']);

Route::get('/trophyInfo/{id}',[gameController::class,'getTrophyInfo']);

Route::get('/leaderboard',[gameController::class,'leaderboard']);

Route::get('/leaderboardWeekly',[gameController::class,'leaderboardWeekly']);

Route::get('/leaderboardMonthly',[gameController::class,'leaderboardMonthly']);

Route::get('/leaderboardToday',[gameController::class,'leaderboardToday']);

Route::get('/all_games',[gameController::class,'getAllGames']);

Route::get('/single_player_game',[gameController::class,'getSinglePlayerGame']);

Route::get('/multi_player_game',[gameController::class,'getMultiPlayerGame']);

Route::post('/userGamePlayedData',[gameController::class,'insertUserGamePlayedData']);









