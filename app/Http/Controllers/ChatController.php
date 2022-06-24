<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChatController extends Controller
{
    function chooseRoom(){
        return view('chooseroom', [
            "user" => Auth::user(),
        ]);
    }

    function createRoomID(){
        $faker = \Faker\Factory::create();

        do{
            $roomId = $faker->regexify('\d{12}');
        }while(Room::where("id", $roomId)->first() instanceof Room);

        return $roomId;
    }

    function createRoom(Request $request){
        // dd($request->room_avatar);
        $validator = Validator::make($request->all(), [
            "room_id" => "required|max:12",
            "room_name" => "required|max:100",
            "room_avatar" => "required",
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all());
        }

        $user = Auth::user();

        $avatar = $request->room_avatar;
        $fileExtension = $avatar->getClientOriginalExtension();
        $fileName = "room-avt-" . $request->room_id . "." . $fileExtension;
        $destinationPath = "images/room_avt/";
        $avatar->move($destinationPath, $fileName);

        $room = Room::create([
            "id" => $request->room_id,
            "name" => $request->room_name,
            "user_id" => $user->id,
            "avatar" => $fileName,
        ]);

        return redirect()->route("messenger", ["room" => $request->room_id]);
    }

    function chat(){
        return redirect()->route("messenger", ["room" => $_REQUEST["room_id"]]);
    }

    function startChat($roomID){
        $user = Auth::user();

        try{
            $room = Room::where('id', $roomID)->firstOrFail();
        }catch(ModelNotFoundException $e) {
            return redirect()->back();
        }

        return view('chat', [
            "room" => $room,
            "user" => $user,
        ]);
    }

    function viewProfile(){
        $user = Auth::user();

        return view('profile', [
            "user" => $user,
        ]);
    }

    function upload(Request $request){
        $this->validate($request, [
            'upload_image' => 'required',
            'upload_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'room_id' => 'required',
        ]);

        $room_id = $request->room_id;
        $listUrl = array();
        foreach($request->file("upload_image") as $file){
            $fileName = uniqid() . "." . $file->getClientOriginalExtension();
            $destinationPath = "images/room_avt/room_" . $room_id . "/";
            $file->move($destinationPath, $fileName);
            array_push($listUrl, $fileName);
        }

        return json_encode($listUrl);
    }

    function saveRoom(){
        return [$_GET["user_id"], $_GET["room_id"]];
    }
}
