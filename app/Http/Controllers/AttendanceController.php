<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Floor;
use App\Models\Room;
use App\Models\StudyRooms;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function prayer(Request $request, $floor = null)
    {
        if (!$floor){
            $floors = Floor::all();
            $users = null;
        }
        else{
            $users = User::where('floor_id', $floor)->get();
            $floors = null;
        }


        if ($request->isMethod('post') && $request->user_id) {
            foreach ($request->user_id as $user_id) {
                $user = User::find($user_id);
                $attendance = new Attendance();
                $attendance->user_id = $user_id;
                $attendance->attendance_type = "prayer";
                $attendance->save();
            }
        }

        return view('attendance.prayer', ['floors' => $floors, 'users' => $users, 'floor' => $floor]);

    }

    public function study(Request $request, $study_room = null)
    {
        if (!$study_room)
            $study_rooms = StudyRooms::all();
        else
            $study_rooms = null;
        if ($study_room)
            $users = User::where('study_room', $study_room)->get();
        else
            $users = null;

        if ($request->isMethod('post') && $request->user_id) {
            foreach ($request->user_id as $user_id) {
                $attendance = new Attendance();
                $attendance->user_id = $user_id;
                $attendance->attendance_type = "study";
                $attendance->save();
            }
        }

        if ($request->isMethod("post"))
            return redirect()->route('attendance.study');

        return view('attendance.study', ['study_rooms' => $study_rooms, 'users' => $users, 'study_room' => $study_room]);
    }

    public function sleep(Request $request, $floor = null, $room = null)
    {
        if (!$floor)
            $floors = Floor::all();
        else
            $floors = null;
        if (!$room)
            $rooms = Room::where('floor_id', $floor)->get();
        else
            $rooms = null;
        if ($room && $floor)
            $users = User::where('room', $room)->get();
        else
            $users = null;


        if ($request->isMethod('post') && $request->user_id) {
            foreach ($request->user_id as $user_id) {
                $attendance = new Attendance();
                $attendance->user_id = $user_id;
                $attendance->attendance_type = "sleep";
                $attendance->save();
            }
        }
        if ($request->isMethod("post"))
            return redirect()->route('attendance.sleep', [$floor]);

        return view('attendance.sleep', ['floors' => $floors, 'rooms' => $rooms, 'floor' => $floor, 'room' => $room, 'users' => $users]);
    }
}
