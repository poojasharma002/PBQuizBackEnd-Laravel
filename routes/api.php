<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Api\gameController;
 use Laravel\Socialite\Facades\Socialite;
 use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Oauth\LoginController;

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

/**
 * 
 * Game API Routes
 * 
 */

Route::get('/games/{id}',[gameController::class,'getGameInfo']);

Route::get('/all_games',[gameController::class,'getAllGames']);

Route::get('/single_player_game',[gameController::class,'getSinglePlayerGame']);

Route::get('/multi_player_game',[gameController::class,'getMultiPlayerGame']);

/**
 * 
 * Trophy API Routes
 * 
 */

Route::get('/trophies',[gameController::class,'getAllTrophies']);

Route::get('/trophyInfo/{id}',[gameController::class,'getTrophyInfo']);

/**
 * 
 * Leaderboard API Routes
 * 
 */

Route::get('/leaderboardAlltime',[gameController::class,'leaderboard']);

Route::get('/leaderboardWeekly',[gameController::class,'leaderboardWeekly']);

Route::get('/leaderboardMonthly',[gameController::class,'leaderboardMonthly']);

Route::get('/leaderboardToday',[gameController::class,'leaderboardToday']);






Route::middleware(['checkHeaderToken'])->group(function () {
    Route::post('/googleOauthLogin', [LoginController::class, 'googleLogin']);
});

Route::get('/facebookOauthLogin', [LoginController::class, 'facebookLogin']);


Route::middleware(['VerifyUser'])->group(function () {
    Route::post('/userGamePlayedData',[gameController::class,'insertUserGamePlayedData']);
    //api to get trophies of a particular user id 
    Route::get('/user_trophies/{id}',[gameController::class,'getUserTrophies']);    

    //get rank of a user in leaderboard in alltime
    Route::post('/leaderboardUserRankAlltime',[gameController::class,'getUserRankAlltime']);
    //get rank of a user in leaderboard in weekly
    Route::post('/leaderboardUserRankWeekly',[gameController::class,'getUserRankWeekly']);
    //get rank of a user in leaderboard in monthly
    Route::post('/leaderboardUserRankMonthly',[gameController::class,'getUserRankMonthly']);
    //get rank of a user in leaderboard in today
    Route::post('/leaderboardUserRankToday',[gameController::class,'getUserRankToday']);
});












