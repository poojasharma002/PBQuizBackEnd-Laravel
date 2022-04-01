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
 * GAME API ROUTES
 * 
 */

Route::get('/games/{id}',[gameController::class,'getGameInfo']);

Route::get('/all_games',[gameController::class,'getAllGames']);

Route::get('/single_player_game',[gameController::class,'getSinglePlayerGame']);

Route::get('/multi_player_game',[gameController::class,'getMultiPlayerGame']);

/**
 * 
 * TROPHY API ROUTES
 * 
 */

Route::get('/trophies',[gameController::class,'getAllTrophies']);

Route::get('/trophyInfo/{id}',[gameController::class,'getTrophyInfo']);

/**
 * 
 *LEADERBOARD API ROUTES(ALL TIME, MONTHLY, WEEKLY, DAILY)
 * 
 */

Route::get('/leaderboardAlltime',[gameController::class,'leaderboard']);

Route::get('/leaderboardWeekly',[gameController::class,'leaderboardWeekly']);

Route::get('/leaderboardMonthly',[gameController::class,'leaderboardMonthly']);

Route::get('/leaderboardToday',[gameController::class,'leaderboardToday']);




/**
 * 
 * GOOGLE OAUTH ROUTES AND FACEBOOK OAUTH ROUTES
 * 
 */

Route::post('/googleOauthLogin', [LoginController::class, 'googleLogin']);

Route::post('/facebookOauthLogin', [LoginController::class, 'facebookLogin']);


/**
 * 
 * REGISTER AND LOGIN API ROUTES (EMAIL AND PASSWORD)
 * 
 */

Route::post('/registerEmail', [SignupLoginController::class, 'register']);

Route::post('/loginEmail', [SignupLoginController::class, 'login']);

/**
 * 
 * FORGOT PASSWORD AND RESET PASSWORD API ROUTES
 * 
 */


Route::post('/forgetPasswordLink', [SignupLoginController::class, 'forgetPassword']);

Route::post('/resetPassword', [SignupLoginController::class, 'resetPassword']);

/**
 * 
 * GET FEATURE GAME AND ALL USER STATS API ROUTES
 * 
 */

Route::get('/get_featured_game',[gameController::class,'getFeaturedGame']);

Route::get('/all_user_played_stats',[gameController::class,'getAllUserPlayedStats']);

//GROUPED MIDDLEWARE ROUTES

Route::middleware(['VerifyUser'])->group(function () {


    /**
     * 
     * USER STATISTICS API ROUTES
     * 
     */

    Route::get('/user_trophies',[gameController::class,'getUserTrophies']);  
    
    Route::get('/user_games',[gameController::class,'getUserGames']);

    Route::get('/particular_user_played_stats',[gameController::class,'getUserPlayedStats']);

    Route::post('/userGamePlayedData',[gameController::class,'insertUserGamePlayedData']);

    Route::get('/user_trophy_won_details',[gameController::class,'getUserTrophyWon']);

    /**
     * 
     * PARTICULAR USER RANK API Routes(ALL TIME, WEEKLY, MONTHLY, TODAY) AND LIVE SCORE API Routes
     * 
     */

    Route::get('/leaderboardUserRankAlltime/{user_id}',[gameController::class,'getUserRankAlltime']);

    Route::get('/leaderboardUserRankWeekly/{user_id}',[gameController::class,'getUserRankWeekly']);

    Route::get('/leaderboardUserRankMonthly/{user_id}',[gameController::class,'getUserRankMonthly']);

    Route::get('/leaderboardUserRankToday/{user_id}',[gameController::class,'getUserRankToday']);

    Route::post('/live-score',[gameController::class,'getLiveScore']);

    /**
     * 
     * USER PROFILE, CHANGE PASSWORD, CHANGE PASSWORD API ROUTES
     * 
     */

    Route::get('/userProfile', [UserController::class, 'userProfile']);   
    
    Route::post('/changeProfilePicture', [UserController::class, 'changeProfilePicture']);

    Route::post('/changePassword', [UserController::class, 'changePassword']);

});


















