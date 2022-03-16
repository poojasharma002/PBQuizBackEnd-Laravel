<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\question;
use App\Models\settings;
use App\Models\trophy;
use Carbon\Carbon;
use App\Models\game;
use Illuminate\Support\Facades\Storage;


class settingsController extends Controller
{
    public function add_tag(){
        //get all tag where type = tag
        $tags = settings::where('type', 'tag')->get();
        return view('pages.admin.setting.add_tag', ['tags' => $tags]);
    }

    public function store_tag(){
        //validate the data
        $this->validate(request(), [
            'tag_name' => 'required',
        ]);
        $tag_name = ucwords(request('tag_name'));

        //create tag
        $setting = new settings;
        $setting->type = "tag";
        $setting->name = $tag_name;
        $setting->save();

        return response()->json(['tag_name' => $tag_name, 'id' => $setting->id]);




        // return redirect()->back()->with('message', 'Tag added successfully');
    }

    public function edit_tag(Request $request){
        $tag = settings::find($request->id);
        $tag_name = ucwords(strtolower($request->tag_name_edit));
        $tag->name = $tag_name;
        $tag->type = "tag";
        $tag->save();

        //get all tag where type = tag
        $tags = settings::where('type', 'tag')->get();
        return view('pages.admin.setting.add_tag', ['tags' => $tags]);
 
    }

    public function destroy_tag(Request $request){

        // if tag is used in any game then it can't be deleted
        $tag = settings::find($request->id);
        $game = game::where('tag', $tag->id)->first();
        //if tag is used in any question then it can't be deleted
   
        //find all questions 
        $questions = question::all();
        //unserialize tags of each question and check if tag id is equal to the tag id that is being deleted
        foreach($questions as $question){
            $tags = unserialize($question->tags);
            if(in_array($request->id, $tags)){
                return response()->json(['message' => 'Tag is used in a question','deleted' => 0]);
            }
        }

        if($game)
        {
            return response()->json(['message' => 'Tag is used in game','deleted' => 0]);
        }
        else
        {
            $response = settings::destroy($request->id);      
            return response()->json(['message' => 'Tag deleted successfully','deleted' => 1]);
        }

    }



    //host 
    public function add_host(){
        //get all host where type = host
        $hosts = settings::where('type', 'host')->get();
        return view('pages.admin.setting.add_host', ['hosts' => $hosts]);
    }

    public function store_host(){
        //validate the data
        $this->validate(request(), [
            'host_name' => 'required',
        ]);
        // make first letter of each word capital
        $host_name = ucwords(strtolower(request('host_name')));
        //create tag
        $setting = new settings;
        $setting->type = "host";
        $setting->name = $host_name;
        $setting->save();

        return response()->json(['host_name' => $host_name, 'id' => $setting->id]);




        // return redirect()->back()->with('message', 'Tag added successfully');
    }

    public function edit_host(Request $request){
        $host = settings::find($request->id);
        $host_name = ucwords(strtolower($request->host_name_edit));
        $host->name = $host_name;
        $host->type = "host";
        $host->save();

        //get all host where type = host
        $hosts = settings::where('type', 'host')->get();
        return view('pages.admin.setting.add_host', ['hosts' => $hosts]);
 
    }

    public function destroy_host(Request $request){
        //check if host is used in any question
        $host_id = $request->id;
        //get host name from id
        // $host_name = settings::find($host_id)->name;
        $questions = question::where('host', $host_id)->first();
        if($questions){
            return response()->json(['message'=>"Host is used in some question. Please delete the question first.",'deleted'=>0]);
        }else{
            $response = settings::destroy($request->id);         
            return response()->json(['message'=>"Host Deleted successfully.", 'deleted'=>1]);
        }

    }

    //add music function start
    public function add_music(){
        // $musics = settings::where('type', 'music')->get();
        $musics = settings::where('type', 'success_audio')
        ->orWhere('type', 'failure_audio')
        ->get();

        if(count($musics) != 0){
            return view('pages.admin.setting.add_music', ['musics' => $musics]);
        }else{
            return view('pages.admin.setting.add_music');
        }

        
    }

    public function store_music(Request $request){
        //validate the data
        $this->validate(request(), [
            // 'music_name' => 'required',
            // 'music_code' => 'required',
        ]);

        $setting = new settings;

        if($request->hasFile('success_audio')){
          //check if success_audio is already exist in database
            $success_audio = settings::where('type', 'success_audio')->first();
            //if exist then delete the old one
            if($success_audio){
                $success_audio->delete();
                //delete audio file
                // $audio_file = public_path('/audio/'.$success_audio->name);
                // if(file_exists($audio_file)){
                //     unlink($audio_file);
                // }else{
                  //extract the file name
                    $audio_file = explode('/', $success_audio->name);
                    $audio_file_name = end($audio_file);
                    unlink(storage_path('app/public/upload/files/audio/'.$audio_file_name));
                // }
                $uniqueid=uniqid();
                $original_name=$request->file('success_audio')->getClientOriginalName();
                $size=$request->file('success_audio')->getSize();
                $extension=$request->file('success_audio')->getClientOriginalExtension();
                $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                $audiopath=url('/storage/upload/files/audio/'.$original_name);
                $request->file('success_audio')->storeAs('public/upload/files/audio/',$original_name);
                $setting->type = "success_audio";
                $setting->name = $audiopath;
                $setting->save();
            }
            else{
                $uniqueid=uniqid();
                $original_name=$request->file('success_audio')->getClientOriginalName();
                $size=$request->file('success_audio')->getSize();
                $extension=$request->file('success_audio')->getClientOriginalExtension();
                $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                $audiopath=url('/storage/upload/files/audio/'.$original_name);
                $request->file('success_audio')->storeAs('public/upload/files/audio/',$original_name);
                $setting->type = "success_audio";
                $setting->name = $audiopath;
                $setting->save();

            }
        }else{
            //check if failure_audio is already exist in database
              $failure_audio = settings::where('type', 'failure_audio')->first();
              //if exist then delete the old one
              if($failure_audio){
                  $failure_audio->delete();
                  //delete audio file
                  $audio_file = public_path('/audio/'.$failure_audio->name);
                //   if(file_exists($audio_file)){
                //       unlink($audio_file);
                //   }else{
                      $audio_file = explode('/', $failure_audio->name);
                      $audio_file_name = end($audio_file);
                      unlink(storage_path('app/public/upload/files/audio/'.$audio_file_name));
                //   }
                  $uniqueid=uniqid();
                  $original_name=$request->file('failure_audio')->getClientOriginalName();
                  $size=$request->file('failure_audio')->getSize();
                  $extension=$request->file('failure_audio')->getClientOriginalExtension();
                  $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                  $audiopath=url('/storage/upload/files/audio/'.$original_name);
                  $request->file('failure_audio')->storeAs('public/upload/files/audio/',$original_name);
                  $setting->type = "failure_audio";
                  $setting->name = $audiopath;
                  $setting->save();
              }
              else{
                  $uniqueid=uniqid();
                  $original_name=$request->file('failure_audio')->getClientOriginalName();
                  $size=$request->file('failure_audio')->getSize();
                  $extension=$request->file('failure_audio')->getClientOriginalExtension();
                  $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                  $audiopath=url('/storage/upload/files/audio/'.$original_name);
                  $request->file('failure_audio')->storeAs('public/upload/files/audio/',$original_name);
                  $setting->type = "failure_audio";
                  $setting->name = $audiopath;
                  $setting->save();
  
              }
        }
        return response()->json(['success' => 'Music added successfully']);
    }

    public function add_trophy(){
        $trophies = trophy::where('deleted', 0)->get();
        return view('pages.admin.setting.add_trophy', ['trophies' => $trophies]);
    }
    public function store_trophy(Request $request){
        $this->validate(request(), [
            'trophy_name' => 'required',
            'trophy_image' => 'required',
            'trophy_desc' => 'required',
        ]);

        $trophy = new trophy;
        $trophy->trophy_name = $request->trophy_name;
        if($request->hasFile('trophy_image')){
            $uniqueid=uniqid();
            $original_name=$request->file('trophy_image')->getClientOriginalName();
            $size=$request->file('trophy_image')->getSize();
            $extension=$request->file('trophy_image')->getClientOriginalExtension();

            $trophy->trophy_image = url('/storage/upload/files/trophy_image/'.$original_name);
            $request->file('trophy_image')->move(public_path('upload/files/trophy_image/'),$original_name);
        }
        $trophy->trophy_desc = $request->trophy_desc;
        $trophy->save();
        return response()->json(['success' => 'Trophy added successfully']);
    }

    public function edit_trophy(Request $request){
        trophy::find($request->edit_id)->update(['trophy_name' =>$request->trophy_name_edit]);
        $trophy = trophy::find($request->edit_id);
        
        if($request->hasFile('trophy_image_edit')){
            $uniqueid=uniqid();
            $original_name=$request->file('trophy_image_edit')->getClientOriginalName();
            $size=$request->file('trophy_image_edit')->getSize();
            $extension=$request->file('trophy_image_edit')->getClientOriginalExtension();
            $filename=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
            $trophy->trophy_image = url('/storage/upload/files/trophy_image/'.$original_name);
            $request->file('trophy_image_edit')->storeAs('public/upload/files/trophy_image/',$original_name);
        }
        $trophy->trophy_desc = $request->trophy_desc_edit;
        $trophy->save();

        return response()->json(['success' => 'Trophy updated successfully']);
    }
    public function delete_trophy(Request $request){
        //check if trophy is linked to any game 
        $trophy_question = game::where('trophy', $request->id)->first();
        //if true then do not delete
        if($trophy_question){
            return response()->json(['message' => 'This trophy is linked to a game.Can not delete','deleted'=>0]);
        }
        else{
            trophy::find($request->id)->update(['deleted' => 1]);
            return response()->json(['message' => 'Trophy deleted successfully','deleted'=>1]);
        }
        // trophy::find($request->id)->update(['deleted' => 1]);
        // return response()->json(['success' => 'Trophy deleted successfully']);
    }

    public function select_featured_game(){
        $games = game::where('deleted', 0)->where('gametype','Single Player')->get();
        //get featured game if exist
        $featured_game = settings::where('type', 'featured_game')->first();
        if($featured_game){
            $featured_game_id = $featured_game->name;
        }
        else{
            $featured_game_id = 0;
        }

        $data = [
            'games' => $games,
            'featured_game_id' => $featured_game_id
        ];
        
        return view('pages.admin.setting.select_featured_game', $data);
    }

    public function store_featured_game(Request $request){
        $this->validate(request(), [
            'featured_game' => 'required',
        ]);

        //INSERT OR UPDATE FEATURED GAME
        $setting = settings::where('type', 'featured_game')->first();
        if($setting){
            $setting->name = $request->featured_game;
            $setting->save();
        }
        else{
            $setting = new settings;
            $setting->type = "featured_game";
            $setting->name = $request->featured_game;
            $setting->save();
        }
        return redirect()->back()->with('success', 'Featured game selected sucessfully.');;
    }
}
