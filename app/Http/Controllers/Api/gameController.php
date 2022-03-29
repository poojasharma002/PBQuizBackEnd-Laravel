<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\gameController;
use App\Models\game;
use App\Models\question;
use App\Models\settings;
use App\Models\trophy;
use App\Models\User;
use App\Models\LiveScore;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\GameRequest;


use App\Models\statistics;
use App\Http\Resources\GameResource;
use Illuminate\Support\Facades\Storage;


class gameController extends Controller
{

/**
 * 
 * ALL GAMES, SINGLE GAMES AND MULTIPLAYER GAMES, PARTICAULAR GAME INFO API FUNCTIONS
 * 
 */

    public function getAllGames()
    {
        try{
            $games = game::where('published',1)
            ->where('deleted',0)
            ->orderBy('schedule_date','asc')
            ->orderBy('schedule_time','asc')
            ->get();

            $games_name_id = [];
            foreach ($games as $game) {
                $games_name_id[] = [
                    'id' => $game->id,
                    'name' => $game->gamename,
                    'image' => $game->game_image,
                    'type' => $game->gametype,
                    'schedule_time' => $game->schedule_time,
                    'schedule_date' => $game->schedule_date
                ];
            }
    
            $data = [
                'success' => true,
                'data' => $games_name_id,
                'error' => null,
                'status' => 200
            ];
            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }

    }

    public function getSinglePlayerGame()
    {
       try{
            $games = game::where('published',1)
            ->where('deleted',0)
            ->where('gametype','Single Player')
            ->orderBy('schedule_date','asc')
            ->orderBy('schedule_time','asc')
            ->get();

            $games_name_id = [];
            foreach ($games as $game) {
                $games_name_id[] = [
                    'id' => $game->id,
                    'name' => $game->gamename,
                    'image' => $game->game_image,
                    'type' => $game->gametype,
                    'schedule_time' => $game->schedule_time,
                    'schedule_date' => $game->schedule_date,
                    'host' => settings::where('id',$game->host)->first()->name,
                ];
            }
    
            $data = [
                'success' => true,
                'data' => $games_name_id,
                'error' => null,
                'status' => 200
            ];
            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function getMultiPlayerGame()
    {
        try{
            date_default_timezone_set("Asia/Calcutta");

            $games =  game::where('published', 1)
            ->where('deleted', 0)
            ->where('gametype', 'Multi Player')
            ->where('game_start_time', '>=',   date('Y-m-d H:i:s'))
            ->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc')
            ->get();

            if(count($games) >= 1)
            {
                foreach ($games as $game) {
                    $games_details[] = [
                        'id' => $game->id,
                        'name' => $game->gamename,
                        'image' => $game->game_image,
                        'schedule_time' => $game->schedule_time,
                        'schedule_date' => $game->schedule_date,
                        'host' => settings::where('id',$game->host)->first()->name,
                    ];
                }
            }else{
                $games_details = "No Multiplayer games available";
            }
    
            $data = [
                'success' => true,
                'data' => $games_details,
                'error' => null,
                'status' => 200
            ];
            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function getGameInfo(Request $request)
    {
        try{
            $game = game::where('id', $request->id)->first();
            $game->host = settings::where('id', $game->host)->where('type', 'host')->first()->name;

            $data = [
                'success' => true,
                'data' => new GameResource($game),
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

/**
 * 
 * ALL TROPHIES AND PARTTICULAR TROPHY API FUNCTIONS
 * 
 */

    public function getAllTrophies()
    {

        try{
            $trophies = trophy::where('deleted', 0)->get();
            $trophies_name_id = [];
            foreach ($trophies as $trophy) {
                $trophies_name_id[] = [
                    'id' => $trophy->id,
                    'name' => $trophy->trophy_name,
                    'image' => $trophy->trophy_image,
                ];
            }
            
            $data = [
                'success' => true,
                'data' => $trophies_name_id,
                'error' => null,
                'status' => 200
            ];
            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }

    }

    public function getTrophyInfo($id)
    {
        try{
            $trophy = trophy::where('id', $id)->first();
            $game = game::where('trophy', $id)->first();
            if ($game == null) {
                $game_name = 'This trophy is not selected for any game';
            } else {
                $game_name = $game->gamename;
            }
            $trophy = [
                'id' => $trophy->id,
                'name' => $trophy->trophy_name,
                'image' => $trophy->trophy_image,
                'description' => $trophy->trophy_desc,
                'game' => $game_name
            ];
            $data = [
                'success' => true,
                'data' => $trophy,
                'error' => null,
                'status' => 200
            ];
            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

/**
 * 
 *  LEADERBOARD(ALL TIME,MONTHLY,WEEKLY,DAILY) API FUNCTIONS
 * 
 */


    public function leaderboard()
    {
        try{
            $user_ids = statistics::distinct()
            ->get(['user_id']);

            $leaderboard = [];
            foreach ($user_ids as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->sum('total_score')
                ];
            }

            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });

            $data = [
                'success' => true,
                'data' => $leaderboard,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function leaderboardToday()
    {
        try{
            $user_ids = statistics::distinct()
            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
            ->get(['user_id']);

            $leaderboard = [];
            foreach ($user_ids as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                        ->sum('total_score')
                ];
            }

            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });

            $data = [
                'success' => true,
                'data' => $leaderboard,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function leaderboardMonthly()
    {
        try{
            $user_ids = statistics::distinct()
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get(['user_id']);

            $leaderboard = [];
            foreach ($user_ids as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                        ->sum('total_score')
                ];
            }

            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });

            $data = [
                'success' => true,
                'data' => $leaderboard,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }

    }

    public function leaderboardWeekly()
    {

        try{
            $user_ids = statistics::distinct()
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get(['user_id']);

            $leaderboard = [];
            foreach ($user_ids as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->sum('total_score')
                ];
            }

            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });

            $data = [
                'success' => true,
                'data' => $leaderboard,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

/**
 * 
 *  INSERT GAME SCORE API FUNCTIONS
 * 
 */

    public function insertUserGamePlayedData(GameRequest $request)
    {
                $headerToken = $request->header('Authorization');
                $user = User::where('token', $headerToken)->first();
                $validatedData = $request->validated();      

                $skipped_question =  $request->total_questions - ($request->correct_answer + $request->incorrect_answer);

                if($request->correct_answer ==  $request->total_questions){
                    $star_won = 1;
                }else{
                    $star_won = 0;
                }

                try{
                    statistics::create([
                        'user_id' => $request->user_id,
                        'game_id' => $request->game_id,
                        'correct_answer' => $request->correct_answer,
                        'incorrect_answer' => $request->incorrect_answer,
                        'skipped_question' => $skipped_question,
                        'total_questions' => $request->total_questions,
                        'total_score' => $request->total_score,
                        // 'game_won' => $request->game_won,
                        'trophy_won' => 1,
                        'star_won'=> $star_won,
                        'game_date' => $request->game_date,
                        'game_time' => $request->game_time
                    ]);
            

                    if ($request->game_won == 1) {
                        $user_id = $user->id;
                        $game_id = $request->game_id;
                        $trophy_id = game::where('id', $game_id)->first()->trophy;
                        trophy::where('id', $trophy_id)->update(['trophy_won' => 1]);
                    }
            
                    $data = [
                        'success' => true,
                        'message' => 'Game played data inserted successfully',
                        'status' => 200
                    ];
            
                    return response()->json($data)->setStatusCode(200);
                }

                catch(Exception $e){
                    $data = [
                        'success' => false,
                        'data' => null,
                        'error' => $e->getMessage(),
                        'status' => 500
                    ];
                    return response()->json($data)->setStatusCode(500);
                }
    }

/**
 * 
 *  PARTICULAR USER GAME AND TROPHIES API FUNCTIONS
 * 
 */

    public function getUserGames(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $user = User::where('token', $headerToken)->first();

        try{
            $user_id = $user->id;
            $statistics = statistics::select('game_id','user_id','correct_answer','incorrect_answer','total_questions','total_score','trophy_won','star_won')
            ->where('user_id', $user_id)
            ->orderBy('total_score', 'desc')
            ->get()
            ->unique('game_id');
            

            $data = [
                'success' => true,
                'data' => $statistics->values(),
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function getUserTrophies(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $user = User::where('token', $headerToken)->first();

        try{
            $user_id = $user->id;
            $statistics = statistics::select('game_id','user_id','correct_answer','incorrect_answer','total_questions','total_score','trophy_won','star_won')
            ->where('user_id', $user_id)
            ->orderBy('total_score', 'desc')
            ->get()
            ->unique('game_id');

            $trophies = [];
            foreach ($statistics as $statistic) {
                $trophies[] = [
                    'game_id' => $statistic->game_id,
                    'correct_answer' => $statistic->correct_answer,
                    'total_questions' => $statistic->total_questions,
                    'trophy_won' => $statistic->trophy_won,
                    'star_won' => $statistic->star_won,
                    'trophy_id' => game::where('id', $statistic->game_id)->first()->trophy
                ];
            }
            

            $data = [
                'success' => true,
                'data' => $trophies,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

/**
 * 
 *  SINGLE PLAYER STATS AND ALL PLAYERS STATS API FUNCTIONS
 * 
 */

    public function getUserPlayedStats(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $user = User::where('token', $headerToken)->first();
        $user_id = $user->id;

        //total number of games played
        $total_games_played = statistics::where('user_id', $user_id)->count();

        //total number of star won in unique games
        $total_star_won = statistics::where('user_id', $user_id)->where('star_won', 1)->count();

        //total number of correct_answer 
        $total_correct_answer = statistics::where('user_id', $user_id)->sum('correct_answer');


        //total number of incorrect_answer
        $total_incorrect_answer = statistics::where('user_id', $user_id)->sum('incorrect_answer');

        //total number of total_score
        $total_score = statistics::where('user_id', $user_id)->sum('total_score');

        //total questions answered by user correct and incorrect
        $total_questions = $total_correct_answer + $total_incorrect_answer;




        //find the game_id which is coming most frequently from statistics table
        $statistics = statistics::select('game_id', DB::raw("count(*) as c"))
            ->where('user_id','=',$user_id)
            ->groupBy('game_id')
            ->get();

        if(count($statistics) >0 ){
            $game_id = $statistics[0]['game_id'];
            $mostPlayedGame = game::where('id', $game_id)->first()->gamename;
        }else{
            $mostPlayedGame = 0;
        }
         


        //calculate total number of perfect games 
        $perfect_games = statistics::where('user_id', $user_id)
            ->where('star_won', 1)
            ->count();

        //total time each game was played
        $total_time = statistics::where('user_id', $user_id)
            ->count('user_id');

        //Total number of consecutive days played (all time)  
        $total_days = statistics::where('user_id', $user_id)
            ->where('created_at', '>', Carbon::now()->subDays(1))
            ->count('user_id');

        //Total number of consecutive days played (current) 
        $current_days = statistics::where('user_id', $user_id)
            ->where('created_at', '>', Carbon::now()->subDays(1))
            ->where('created_at', '<', Carbon::now())
            ->count('user_id');


        $total_games = game::count();
        
        //calculate the games completed by user from statistics table where star_won is 1
        $games_completed = statistics::where('user_id', $user_id)
            ->distinct('game_id')
            ->where('star_won', 1)
            ->count();

        
        $data = [
            'success' => true,
            'data' => [
                'total_games_played' => $total_games_played,
                'total_star_won' => $total_star_won,
                'total_correct_answer' => $total_correct_answer,
                'total_incorrect_answer' => $total_incorrect_answer,
                'total_score' => $total_score,
                'total_questions_answer' => $total_questions,
                'perfect_games' => $perfect_games,
                'total_time' => $total_time,
                'total_days' => $total_days,
                'current_days' => $current_days,
                'most_played_game' => $mostPlayedGame,
                'games_completed' => $games_completed,
                'total_games_available' => $total_games,
            ],
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

    public function getAllUserPlayedStats(Request $request)
    {
       //get all unique user where role is user 
        $users = User::where('role', 'user')->get()->unique('id');
        //get all statistics of each user
        $statistics = [];
        foreach ($users as $user) {
            $statistics[] = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'total_games_played' => statistics::where('user_id', $user->id)->count(),
                'total_star_won' => statistics::where('user_id', $user->id)->where('star_won', 1)->count(),
                'total_correct_answer' => statistics::where('user_id', $user->id)->sum('correct_answer'),
                'total_incorrect_answer' => statistics::where('user_id', $user->id)->sum('incorrect_answer'),
                'total_score' => statistics::where('user_id', $user->id)->sum('total_score'),
                'total_questions_answer' => statistics::where('user_id', $user->id)->sum('correct_answer') + statistics::where('user_id', $user->id)->sum('incorrect_answer'),
                'perfect_games' => statistics::where('user_id', $user->id)
                    ->where('star_won', 1)
                    ->count(),
                'total_time' => statistics::where('user_id', $user->id)->count('user_id'),
                'total_days' => statistics::where('user_id', $user->id)
                    ->where('created_at', '>', Carbon::now()->subDays(1))
                    ->count('user_id'),
                'current_days' => statistics::where('user_id', $user->id)
                    ->where('created_at', '>', Carbon::now()->subDays(1))
                    ->where('created_at', '<', Carbon::now())
                    ->count('user_id'),

                'completed_games' => statistics::where('user_id', $user->id)
                    ->groupBy('game_id')
                    ->where('star_won', 1)
                    ->count('star_won')
            ];
        }

        $data = [
            'success' => true,
            'data' => $statistics,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);


    }

/**
 * 
 *  USER RANK(ALL TIME, MONTHLY, WEEKLY, DAILY) API FUNCTIONS
 * 
 */


    public function getUserRankAlltime(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');

        try{
            $user = User::where('token', $headerToken)->first();
            $current_user_id = $id;

            $userIds = statistics::distinct()
                ->get(['user_id']);

            $leaderboard = [];
            foreach ($userIds as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->sum('total_score'),
                ];
            }  
            //sort by highest score 
            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });
            //add rank to the leaderboard
            $i = 1;
            foreach ($leaderboard as $key => $value) {
                $leaderboard[$key]['rank'] = $i;
                $i++;
            }

            //get the data of the current user
            $current_user_data = [];
            foreach ($leaderboard as $key => $value) {
                if ($value['user_id'] == $current_user_id) {
                    $current_user_data = $value;
                }
            }
            if(count($current_user_data) == 0){
                $current_user_data = "No Rank Available";
            }
            $data = [
                'success' => true,
                'data' => $current_user_data,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            $data = [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'status' => 500
            ];

            return response()->json($data)->setStatusCode(500);
        }
    }

    public function getUserRankWeekly(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');

        try{
            $user = User::where('token', $headerToken)->first();
            $current_user_id = $id;

            $userIds = statistics::distinct()
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->get(['user_id']);

            $leaderboard = [];
            foreach ($userIds as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->sum('total_score'),
                ];
            }  
            //sort by highest score 
            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });
            //add rank to the leaderboard
            $i = 1;
            foreach ($leaderboard as $key => $value) {
                $leaderboard[$key]['rank'] = $i;
                $i++;
            }

            //get the data of the current user
            $current_user_data = [];
            foreach ($leaderboard as $key => $value) {
                if ($value['user_id'] == $current_user_id) {
                    $current_user_data = $value;
                }
            }
            if(count($current_user_data) == 0){
                $current_user_data = "No Rank Available";
            }
            $data = [
                'success' => true,
                'data' => $current_user_data,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }

        catch(Exception $e){
            $data = [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'status' => 500
            ];

            return response()->json($data)->setStatusCode(500);
        }

    }

    public function getUserRankToday(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');

        try{
            $user = User::where('token', $headerToken)->first();
            $current_user_id = $id;

            $userIds = statistics::distinct()
                ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                ->get(['user_id']);

            $leaderboard = [];
            foreach ($userIds as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
                        ->sum('total_score'),
                ];
            }  
            //sort by highest score 
            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });
            //add rank to the leaderboard
            $i = 1;
            foreach ($leaderboard as $key => $value) {
                $leaderboard[$key]['rank'] = $i;
                $i++;
            }

            //get the data of the current user
            $current_user_data = [];
            foreach ($leaderboard as $key => $value) {
                if ($value['user_id'] == $current_user_id) {
                    $current_user_data = $value;
                }
            }
            if(count($current_user_data) == 0){
                $current_user_data = "No Rank Available";
            }
            $data = [
                'success' => true,
                'data' => $current_user_data,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
        catch(Exception $e){
            $data = [
                'success' => false,
                'data' => null,
                'error' => $e->getMessage(),
                'status' => 500
            ];

            return response()->json($data)->setStatusCode(500);
        }
        
    }

    public function getUserRankMonthly(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');

        try{
            $user = User::where('token', $headerToken)->first();
            $current_user_id = $id;

            $userIds = statistics::distinct()
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->get(['user_id']);

            $leaderboard = [];
            foreach ($userIds as $user_id) {
                $leaderboard[] = [
                    'user_id' => $user_id->user_id,
                    'top_scorer_name' => explode(' ', $user_id->user->name)[0],
                    'score' => statistics::where('user_id', $user_id->user_id)
                        ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                        ->sum('total_score'),
                ];
            }  
            //sort by highest score 
            usort($leaderboard, function ($a, $b) {
                return $b['score'] - $a['score'];
            });
            //add rank to the leaderboard
            $i = 1;
            foreach ($leaderboard as $key => $value) {
                $leaderboard[$key]['rank'] = $i;
                $i++;
            }

            //get the data of the current user
            $current_user_data = [];
            foreach ($leaderboard as $key => $value) {
                if ($value['user_id'] == $current_user_id) {
                    $current_user_data = $value;
                }
            }
            if(count($current_user_data) == 0){
                $current_user_data = "No Rank Available";
            }
            $data = [
                'success' => true,
                'data' => $current_user_data,
                'error' => null,
                'status' => 200
            ];

            return response()->json($data)->setStatusCode(200);
        }
            
            catch(Exception $e){
                $data = [
                    'success' => false,
                    'data' => null,
                    'error' => $e->getMessage(),
                    'status' => 500
                ];

                return response()->json($data)->setStatusCode(500);
            }
    }

/**
 * 
 *  LIVE SCORE AND FEATURE GAME API FUNCTIONS
 * 
 */

    public function getLiveScore(Request $request){

        $request->validate([
            'user_id'=> 'required|integer',
            'user_name' => 'required|string',
            'user_email' => 'required|string|email',
            'live_score' => 'required|integer',
            'game_id' => 'required|integer',
        ]);


        $user_id = $request->user_id;
        $user_name = $request->user_name;
        $user_email = $request->user_email;
        $live_score = $request->live_score;
        $game_id = $request->game_id;

        $gameIsAlreadyPlayed = LiveScore::where('game_id', '!=', $game_id )->first();
        if ($gameIsAlreadyPlayed === null) {
            
        $liveScore = LiveScore::updateOrCreate(
            [
               'user_id'   => $user_id,
            ],
            [
               'user_name'  => $user_name,
               'user_email' => $user_email,
               'live_score' => $live_score,
               'game_id' => $game_id
            ],
        );

        $liveScores = LiveScore::orderBy('live_score', 'desc')->get();

        $data = [
            'success' => true,
            'data' => $liveScores,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);

        }else{
            LiveScore::truncate();

            $liveScore = LiveScore::updateOrCreate(
                [
                   'user_id'   => $user_id,
                ],
                [
                   'user_name'  => $user_name,
                   'user_email' => $user_email,
                   'live_score' => $live_score,
                   'game_id' => $game_id
                ],
            );
    
            $liveScores = LiveScore::orderBy('live_score', 'desc')->get();
    
            $data = [
                'success' => true,
                'data' => $liveScores,
                'error' => null,
                'status' => 200
            ];
    
            return response()->json($data)->setStatusCode(200);
        }


    }

    public function getFeaturedGame(Request $request){
         $feature_game = Settings::where('type', 'featured_game')->first();
            $game_id = $feature_game->name;
            $host_name = game::where('id', $game_id)->first()->host;
            $feature_game->host = $host_name;
            $data = [
                'success' => true,
                'data' => $feature_game,
                'error' => null,
                'status' => 200
            ];
        
        return response()->json($data)->setStatusCode(200);
    }
    
}
