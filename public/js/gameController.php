<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\gameController;
use App\Models\game;
use App\Models\question;
use App\Models\settings;
use App\Models\statistics;
use App\Models\trophy;
use App\Http\Resources\GameResource;
use Illuminate\Support\Facades\Storage;


class gameController extends Controller
{
    public function getAllGames(){
        $games = game::all();
        // return (GameResource::collection($games))->response()->setStatusCode(200);
        //get all games name and id
        $games_name_id = [];
        foreach($games as $game){
            $games_name_id[] = [
                'id'=>$game->id,
                'name'=>$game->gamename,
                'image'=>$game->game_image,
                'type'=>$game->gametype,
                'schedule_time'=>$game->schedule_time,
                'schedule_date'=>$game->schedule_date
            ];
        }
        return response()->json($games_name_id)->setStatusCode(200);

    }

    public function getAllTrophies(){
        $trophies = trophy::where('deleted',0)->get();
        $trophies_name_id = [];
        foreach($trophies as $trophy){
            $trophies_name_id[] = [
                'id'=>$trophy->id,
                'name'=>$trophy->trophy_name,
                'image'=>$trophy->trophy_image,
            ];
        }
        return response()->json($trophies_name_id)->setStatusCode(200);
    }


    public function getGameInfo(Request $request){
        $game = game::where('id',$request->id)->first();
        $game->tag = settings::where('id',$game->tag)->where('type','tag')->first()->name;
        return new GameResource($game);
    }
     public function insertUserGamePlayedData(Request $request){
        $this->validate(request(), [
            'user_id' => 'required|integer',
            'game_id' => 'required|integer',
            'correct_answer' => 'required|integer',
            'incorrect_answer' => 'required|integer',
            'skipped_answer' => 'required|integer',
            'total_score' => 'required|integer',
            'game_won' => 'required|boolean',
            'trophy_won' => 'required|boolean',
            'game_date' => 'required|date',
            'game_time' => 'required|string',
        ]);
        statistics::create([
            'user_id' => $request->user_id,
            'game_id' => $request->game_id,
            'correct_answer' => $request->correct_answer,
            'incorrect_answer' => $request->incorrect_answer,
            'skipped_answer' => $request->skipped_answer,
            'total_score' => $request->total_score,
            'game_won' => $request->game_won,
            'trophy_won' => $request->trophy_won,
            'game_date' => $request->game_date,
            'game_time' => $request->game_time
        ]);
        $data= [
            'message'=> 'Success',
            'status'=> 200
        ];

        return response()->json($data)->setStatusCode(200);
        
    }
}
