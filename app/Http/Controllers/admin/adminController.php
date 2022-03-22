<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\question;
use App\Models\settings;
use App\Models\game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\trophy;
use App\Http\Requests\Admin\QuestionRequest;


class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * 
     * Add Question, Update Question, Delete Question , Get All Questions Controller
     * 
     */

    public function all_questions()
    {
        $questions = question::where('deleted', '0')->get();
        return view('pages.admin.all-questions', compact('questions'));
    }

    public function add_question()
    {
        $hosts = settings::where('type', 'host')->get();
        $tags = settings::where('type', 'tag')->get();
        return view('pages.admin.add_question', ['hosts' => $hosts, 'tags' => $tags]);
    }


    public function store_question(QuestionRequest $request)
    {
        $validated = $request->validated();
        question::create([
            'video_code' => $request->input('video_code'),
            'question' => $request->input('question'),
            'option_one' => $request->input('option_one'),
            'option_two' => $request->input('option_two'),
            'option_three' => $request->input('option_three'),
            'correct_answer' => $request->input('correct_answer'),
            'difficulty_level' => $request->input('difficulty_level'),
            'tags' => serialize($request->input('tag')),
            'host' => $request->input('host'),
            'question_time' => $request->input('question_time'),
        ]);
        return redirect()->back()->with('message', 'Question added successfully');
    }

    public function edit_question($ques_id)
    {

        $question = question::find($ques_id);
        $tags = settings::where('type', 'tag')->get();
        $hosts = settings::where('type', 'host')->get();
        $tag_id = unserialize($question->tags);
        $tag_name_array = settings::whereIn('id', $tag_id)->get();
        $host_id = $question->host;
        $host_name = settings::where('id', $host_id)->first()->name;
        return view('pages.admin.edit-question', ['question' => $question, 'tags' => $tags, 'hosts' => $hosts, 'host_name' => $host_name, 'tag_name_array' => $tag_name_array]);
    }

    public function update_question(QuestionRequest $request, $id)
    {
        $validated = $request->validated();

        question::find($id)->update([
            'video_code' => $request->input('video_code'),
            'question' => $request->input('question'),
            'option_one' => $request->input('option_one'),
            'option_two' => $request->input('option_two'),
            'option_three' => $request->input('option_three'),
            'correct_answer' => $request->input('correct_answer'),
            'difficulty_level' => $request->input('difficulty_level'),
            'tags' => serialize($request->input('tag')),
            'host' => $request->input('host'),
            'question_time' => $request->input('question_time'),
        ]);
        return redirect()->route('all-questions')->with('success', 'Question Updated Successfully');
    }

    public function deleted_question(Request $request)
    {
        $id = $request->input('id');
        question::find($id)->update(['deleted' => 1]);
        return response()->json(['success' => "Question Deleted successfully."]);
    }

    /**
     * 
     * Add Game, Update Game, Delete Game , Get All Games Controller
     * 
     */


    public function create_game()
    {
        $questions = question::where('deleted', '0')->get();
        $tags = settings::where('type', 'tag')->get();
        $trophies = trophy::where('deleted', '0')->whereNotIn('id', function ($query) {
            $query->select('trophy')->from('games');
        })->get();
        $hosts = settings::where('type', 'host')->get();

        $data = [
            'questions' => $questions,
            'tags' => $tags,
            'trophies' => $trophies,
            'hosts' => $hosts,
        ];
        return view('pages.admin.games.create_game', $data);
    }

    public function store_game(Request $request)
    {

        $round_1_questions = $request->input('round_1_questions');
        $round_2_questions = $request->input('round_2_questions');
        $round_3_questions = $request->input('round_3_questions');

        $round_1_questions_id = array();
        foreach ($round_1_questions as $key => $value) {
            $round_1_questions_id[] = question::where('question', $value)->first()->id;
        }
        $round_2_questions_id = array();
        foreach ($round_2_questions as $key => $value) {
            $round_2_questions_id[] = question::where('question', $value)->first()->id;
        }
        $round_3_questions_id = array();
        foreach ($round_3_questions as $key => $value) {
            $round_3_questions_id[] = question::where('question', $value)->first()->id;
        }

        if ($request->hasFile('game_image')) {
            $uniqueid = uniqid();
            $original_name = $request->file('game_image')->getClientOriginalName();
            $size = $request->file('game_image')->getSize();
            $extension = $request->file('game_image')->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $imagepath = url('/storage/upload/files/game_image/' . $filename);
            $request->file('game_image')->storeAs('public/upload/files/game_image/', $filename);
        }

        if ($request->input('gametype') == 'Single Player') {
            $schedule_date = null;
            $schedule_time = null;
        } else {
            $schedule_date = $request->input('schedule_date');
            $schedule_time = $request->input('schedule_time');
        }
        if ($request->hasfile('music_file')) {
            $uniqueid = uniqid();
            $original_name = $request->file('music_file')->getClientOriginalName();
            $size = $request->file('music_file')->getSize();
            $extension = $request->file('music_file')->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $musicpath = url('/storage/upload/files/game_music/' . $original_name);
            $request->file('music_file')->storeAs('public/upload/files/game_music/', $original_name);
        }

        game::create([
            'gamename' => $request->input('gamename'),
            'gametype' => $request->input('gametype'),
            'schedule_date' => $schedule_date,
            'schedule_time' => $schedule_time,
            'game_start_time' => $schedule_date . ' ' . $schedule_time,
            'level' => $request->input('level'),
            'tag' => serialize($request->input('tag')),
            'host' => $request->input('host'),
            'host_video_snippet' => $request->input('host_video_snippet'),
            'music_file' => $musicpath,
            'game_image' => $imagepath,
            'high_perf_message' => $request->input('high_perf_message'),
            'low_perf_message' => $request->input('low_perf_message'),
            'trophy' => $request->input('trophy'),
            'published' => $request->input('published'),
            'round1_starting_video_snippet' => $request->input('round1_starting_video_snippet'),
            'round2_starting_video_snippet' => $request->input('round2_starting_video_snippet'),
            'round3_starting_video_snippet' => $request->input('round3_starting_video_snippet'),
            'round_1_questions' => serialize($round_1_questions_id),
            'round_2_questions' => serialize($round_2_questions_id),
            'round_3_questions' => serialize($round_3_questions_id),
            'time_down_video_snippet' => $request->input('time_down_video_snippet')
        ]);

        return redirect()->back()->with('message', 'Game added successfully');
    }

    public function all_games()
    {
        $games = game::all();
        $trophies = array();
        $tags = array();
        foreach ($games as $key => $value) {
            $tags[] = $value->tag;
        }
        foreach ($games as $key => $value) {

            $trophy_id = $value->trophy;
            $trophies[$key]['games'] = $value;
            $trophies[$key]['trophy'] = trophy::where('id', $trophy_id)->first();
        }

        $data = [
            'data' =>  $trophies
        ];
        return view('pages.admin.games.all_games', $data);
    }

    public function edit_game(Request $request, $id)
    {
        $tags = settings::where('type', 'tag')->get();
        $game = game::find($id);
        $round_1_questions = unserialize($game->round_1_questions);
        $round_2_questions = unserialize($game->round_2_questions);
        $round_3_questions = unserialize($game->round_3_questions);
        $questions = question::where('deleted', '0')->get();

        $round_1_questions_id = array();
        foreach ($round_1_questions as $key => $value) {
            $round_1_questions_id[] = question::where('id', $value)->first()->question;
        }
        $round_2_questions_id = array();
        foreach ($round_2_questions as $key => $value) {
            $round_2_questions_id[] = question::where('id', $value)->first()->question;
        }
        $round_3_questions_id = array();
        foreach ($round_3_questions as $key => $value) {
            $round_3_questions_id[] = question::where('id', $value)->first()->question;
        }

        $game_tag = $game->tag;
        $game_tag_name = "Test";

        $tag_id = unserialize($game->tag);
        $tag_name_array = settings::whereIn('id', $tag_id)->get();
        $trophy_id = $game->trophy;
        $trophy = trophy::where('id', $trophy_id)->where('deleted', '0')->get();

        $trophies = trophy::where('deleted', '0')->whereNotIn('id', function ($query) use ($id) {
            $query->select('trophy')->from('games')->where('id', '!=', $id);
        })->get();
        foreach ($trophy as $key => $value) {
            $trophy = $value;
        }

        $hosts = settings::where('type', 'host')->get();
        $host_id = $game->host;
        $host_name = settings::where('id', $host_id)->first()->name;

        $data = [
            'game' => $game,
            'questions' => $questions,
            'round_1_questions_id' => $round_1_questions_id,
            'round_2_questions_id' => $round_2_questions_id,
            'round_3_questions_id' => $round_3_questions_id,
            'tags' => $tags,
            'game_tag' => $game_tag,
            'game_tag_name' => $game_tag_name,
            'tag_name_array' => $tag_name_array,
            'all_trophies' => $trophies,
            'trophy' => $trophy,
            'hosts' => $hosts,
            'host_name' => $host_name
        ];

        return view('pages.admin.games.edit_game', $data);
    }

    public function update_game(Request $request, $id)
    {
        $game = game::find($id);
        $round_1_questions = $request->input('round_1_questions');
        $round_2_questions = $request->input('round_2_questions');
        $round_3_questions = $request->input('round_3_questions');

        $round_1_questions_id = array();
        foreach ($round_1_questions as $key => $value) {
            $round_1_questions_id[] = question::where('question', $value)->first()->id;
        }
        $round_2_questions_id = array();
        foreach ($round_2_questions as $key => $value) {
            $round_2_questions_id[] = question::where('question', $value)->first()->id;
        }
        $round_3_questions_id = array();
        foreach ($round_3_questions as $key => $value) {
            $round_3_questions_id[] = question::where('question', $value)->first()->id;
        }

        if ($request->hasfile('music_file')) {
            $uniqueid = uniqid();
            $original_name = $request->file('music_file')->getClientOriginalName();
            $size = $request->file('music_file')->getSize();
            $extension = $request->file('music_file')->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $musicpath = url('/storage/upload/files/game_music/' . $original_name);
            $request->file('music_file')->storeAs('public/upload/files/game_music/', $original_name);
        } else {
            $musicpath = $game->music_file;
        }

        $game->gamename = $request->input('gamename');
        $game->gametype = $request->input('gametype');

        if ($request->input('gametype') == 'Single Player') {
            $game->schedule_date = null;
            $game->schedule_time = null;
        } else {
            $game->schedule_date = $request->input('schedule_date');
            $game->schedule_time = $request->input('schedule_time');
        }
        $game->level = $request->input('level');
        $game->tag = serialize($request->input('tag'));
        $game->host = $request->input('host');
        $game->music_file = $musicpath;
        $game->host_video_snippet = $request->input('host_video_snippet');
        $game->high_perf_message = $request->input('high_perf_message');
        $game->low_perf_message = $request->input('low_perf_message');
        $game->trophy = $request->input('trophy');
        $game->published = $request->input('published');

        $game->round_1_questions = serialize($round_1_questions_id);
        $game->round_2_questions = serialize($round_2_questions_id);
        $game->round_3_questions = serialize($round_3_questions_id);

        $game->time_down_video_snippet = $request->input('time_down_video_snippet');
        $game->round1_starting_video_snippet = $request->input('round1_starting_video_snippet');
        $game->round2_starting_video_snippet = $request->input('round2_starting_video_snippet');
        $game->round3_starting_video_snippet = $request->input('round3_starting_video_snippet');

        if ($request->hasFile('game_image')) {
            $uniqueid = uniqid();
            $original_name = $request->file('game_image')->getClientOriginalName();
            $size = $request->file('game_image')->getSize();
            $extension = $request->file('game_image')->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $imagepath = url('/storage/upload/files/game_image/' . $filename);

            $request->file('game_image')->storeAs('public/upload/files/game_image/', $filename);
            $game->game_image = $imagepath;
        }

        $game->save();
        return redirect(route('all_games'))->with('message', 'Game updated successfully');
    }

    public function publish_game(Request $request)
    {
        $game = game::find($request->id);
        if ($game->published == '1') {
            $game->published = '0';
        } else {
            $game->published = '1';
        }
        $game->save();
        return redirect(route('all_games'))->with('message', 'Game published successfully');
    }



    public function delete_game(Request $request)
    {
        $response = game::destroy($request->id);
        return response()->json(['success' => "Game Deleted successfully."]);
    }

    /**
     * 
     *   Get All Users Controller, Delete Users
     * 
     */

    public function all_users(Request $request)
    {
        $users = User::where('role', 'user')->get();
        $data = [
            'data' =>  $users
        ];
        return view('pages.admin.users.all_users', $data);
    }

    public function delete_user(Request $request)
    {
        $response = User::destroy($request->id);
        return response()->json(['success' => "User Deleted successfully."]);
    }

    public function change_status(Request $request)
    {
        $user = User::find($request->id);
        if ($user->status == '1') {
            $user->status = '0';
        } else {
            $user->status = '1';
        }
        
        $user->save();
        return redirect(route('all_users'))->with('message', 'User status changed successfully');
    }
  
}
