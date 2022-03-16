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
        //get games which are published and not deleted and order and game type is single player
        //by schedule_date and schedule_time
        $games = game::where('published', 1)->where('deleted', 0)->where('gametype', 'Single Player')->get();

        foreach ($games as $game) {
            $games_details[] = [
                'id' => $game->id,
                'name' => $game->gamename,
                'image' => $game->game_image,
            ];
        }

        $data = [
            'success' => true,
            'data' => $games_details,
            'error' => null,
            'status' => 200
        ];
        return response()->json($data)->setStatusCode(200);
    }

    public function getMultiPlayerGame()
    {
        //get games which are published and not deleted and game type is multi player order by schedule_date and schedule_time
        $games = game::where('published', 1)->where('deleted', 0)->where('gametype', 'Multi Player')
            ->orderBy('schedule_date', 'asc')->orderBy('schedule_time', 'asc')->get();



        foreach ($games as $game) {
            $games_details[] = [
                'id' => $game->id,
                'name' => $game->gamename,
                'image' => $game->game_image,
                'schedule_time' => $game->schedule_time,
                'schedule_date' => $game->schedule_date
            ];
        }

        $data = [
            'success' => true,
            'data' => $games_details,
            'error' => null,
            'status' => 200
        ];
        return response()->json($data)->setStatusCode(200);
    }


    public function getAllTrophies()
    {
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

    public function getTrophyInfo($id)
    {
        //get trophy is linked to which game and return game name
        $game = game::where('trophy', $id)->first();

        $trophy = trophy::where('id', $id)->first();
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

    public function getGameInfo(Request $request)
    {
        $game = game::where('id', $request->id)->first();

        //get tag name from tag id in setting table
        // $game->tag = settings::where('id',$game->tag)->where('type','tag')->first()->name;
        $game->host = settings::where('id', $game->host)->where('type', 'host')->first()->name;
        // $game->trophy = trophy::where('id',$game->tag)->first()->name;'

        $data = [
            'success' => true,
            'data' => new GameResource($game),
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

    public function leaderboard()
    {

        // $leaderboard = statistics::select('user_id','score')->where('game_id',$request->id)->orderBy('score','desc')->limit(3)->get();
        // prev code
        // $topThreeScorer = statistics::distinct()->orderBy('total_score','desc')->limit(8)->get(['user_id','total_score']);
        // dd($topThreeScorer);
        // $leaderboard = [];
        // foreach($topThreeScorer as $scorer){
        //     $leaderboard[] = [
        //         'user_id'=>$scorer->user_id,
        //         'top_scorer_name'=>$scorer->user->name,
        //         'score'=>$scorer->total_score
        //     ];
        // }
        //prev code end

        $user_ids = statistics::distinct()
            ->limit(10)
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
        $leaderboard = array_slice($leaderboard, 0, 8);


        $data = [
            'success' => true,
            'data' => $leaderboard,
            'error' => null,
            'status' => 200
        ];
        return response()->json($data)->setStatusCode(200);
    }

    public function leaderboardToday()
    {
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

        //sort by highest score and return top 3
        usort($leaderboard, function ($a, $b) {
            return $b['score'] - $a['score'];
        });

        $leaderboard = array_slice($leaderboard, 0, 8);


        $data = [
            'success' => true,
            'data' => $leaderboard,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

    public function leaderboardMonthly()
    {
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
                    ->sum('total_score')
            ];
        }

        //sort by highest score and return top 3
        usort($leaderboard, function ($a, $b) {
            return $b['score'] - $a['score'];
        });

        $leaderboard = array_slice($leaderboard, 0, 10);

        $data = [
            'success' => true,
            'data' => $leaderboard,
            'error' => null,
            'status' => 200
        ];
        return response()->json($data)->setStatusCode(200);
    }

    public function leaderboardWeekly()
    {
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
                    ->sum('total_score')
            ];
        }

        //sort by highest score and return top 3
        usort($leaderboard, function ($a, $b) {
            return $b['score'] - $a['score'];
        });

        $leaderboard = array_slice($leaderboard, 0, 10);

        $data = [
            'success' => true,
            'data' => $leaderboard,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

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

    public function getUserGames(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $user = User::where('token', $headerToken)->first();

        $user_id = $user->id;

        //get all information from statistics table where user_id is unique and total_score is highest
        $statistics = statistics::where('user_id', $user_id)
            ->orderBy('total_score', 'desc')
            ->get()
            ->unique('game_id');

        $data = [
            'success' => true,
            'data' => $statistics,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

    public function getUserTrophies(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $user = User::where('token', $headerToken)->first();
        $user_id = $user->id;

        $statistics = statistics::where('user_id', $user_id)
            ->orderBy('total_score', 'desc')
            ->get()
            ->unique('game_id');

        //get trophy details of their respective game
        $trophies = [];
        foreach ($statistics as $statistic) {
            $trophies[] = [
                'game_id' => $statistic->game_id,
                'correct_answer' => $statistic->correct_answer,
                'total_questions' => $statistic->total_questions,
                'trophy_won' => $statistic->trophy_won,
                'star_won' => $statistic->star_won,
                'trophy_id' => game::where('id', $statistic->game_id)->first()->trophy,
                'trophy_name' => trophy::where('id', game::where('id', $statistic->game_id)->first()->trophy)->first()->trophy_name,
                'trophy_image' => trophy::where('id', game::where('id', $statistic->game_id)->first()->trophy)->first()->trophy_image,
                'trophy_description' => trophy::where('id', game::where('id', $statistic->game_id)->first()->trophy)->first()->trophy_description,
                'trophy_won' => trophy::where('id', game::where('id', $statistic->game_id)->first()->trophy)->first()->trophy_won
            ];
        }

        $data = [
            'success' => true,
            'data' =>$trophies,
            'error' => null,
            'status' => 200
        ];






        return response()->json($data)->setStatusCode(200);
    }

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
            $game_id = $statistics[0]['game_id'];

            $mostPlayedGame = game::where('id', $game_id)->first()->gamename;


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
                // 'most_played_game' => statistics::select('game_id', DB::raw("count(*) as c"))
                //     ->where('user_id','=',$user->id)
                //     ->groupBy('game_id')
                //     ->get()[0]['game_id'],

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



    public function getUserRankAlltime(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');
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
        $data = [
            'success' => true,
            'data' => $current_user_data,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

    public function getUserRankWeekly(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');
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
                    'gdfgdf'=>1
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
        $data = [
            'success' => true,
            'data' => $current_user_data,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);

    }

    public function getUserRankToday(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');
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
        $data = [
            'success' => true,
            'data' => $current_user_data,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

    public function getUserRankMonthly(Request $request,$id)
    {
        $headerToken = $request->header('Authorization');
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
        $data = [
            'success' => true,
            'data' => $current_user_data,
            'error' => null,
            'status' => 200
        ];

        return response()->json($data)->setStatusCode(200);
    }

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
       //get feature game from settings
         $feature_game = Settings::where('type', 'featured_game')->first();
            $data = [
                'success' => true,
                'data' => $feature_game,
                'error' => null,
                'status' => 200
            ];
        
        return response()->json($data)->setStatusCode(200);
    }
    
}
