<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Api\gameController;
 use App\Http\Controllers\Api\SignupLoginController;
 use App\Http\Controllers\Api\UserController;
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

Route::middleware(['VerifyUser'])->group(function () {

    Route::post('/userGamePlayedData',[gameController::class,'insertUserGamePlayedData']);

    /**
     * 
     * Statistics API Routes
     * 
     */

    Route::get('/user_trophies/{id}',[gameController::class,'getUserTrophies']);  
    
    Route::get('/user_games/{id}',[gameController::class,'getUserGames']);

    Route::get('/particular_user_played_stats',[gameController::class,'getUserPlayedStats']);

    //player rank in leaderboard 

    Route::get('/leaderboardUserRankAlltime/{user_id}',[gameController::class,'getUserRankAlltime']);

    Route::get('/leaderboardUserRankWeekly/{user_id}',[gameController::class,'getUserRankWeekly']);

    Route::get('/leaderboardUserRankMonthly/{user_id}',[gameController::class,'getUserRankMonthly']);

    Route::get('/leaderboardUserRankToday/{user_id}',[gameController::class,'getUserRankToday']);

    // user profile dashboard

    Route::get('/userProfile', [UserController::class, 'userProfile']);   
    
    //change user profile picture
    Route::post('/changeProfilePicture', [UserController::class, 'changeProfilePicture']);

    //change user password
    Route::post('/changePassword', [UserController::class, 'changePassword']);

    //live-score api

    Route::post('/live-score',[gameController::class,'getLiveScore']);
});



/**
 * 
 * Google and Facebook Oauth Routes
 * 
 */
Route::middleware(['checkHeaderToken'])->group(function () {
    Route::post('/googleOauthLogin', [LoginController::class, 'googleLogin']);
});

Route::post('/facebookOauthLogin', [LoginController::class, 'facebookLogin']);


/**
 * 
 * Registration and Login Routes(email based)
 * 
 */

Route::post('/registerEmail', [SignupLoginController::class, 'register']);

Route::post('/loginEmail', [SignupLoginController::class, 'login']);

//forget password 

Route::post('/forgetPasswordLink', [SignupLoginController::class, 'forgetPassword']);

//change password 

Route::post('/resetPassword', [SignupLoginController::class, 'resetPassword']);

Route::get('/all_user_played_stats',[gameController::class,'getAllUserPlayedStats']);

//get featured game

Route::get('/get_featured_game',[gameController::class,'getFeaturedGame']);


















