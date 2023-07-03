<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Floor;
use App\Models\Room;
use App\Models\StudyRooms;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\exactly;
use function Symfony\Component\String\s;

class AttendanceController extends Controller
{
    public function prayer(Request $request, $floor = null, $prayer_type = null)
    {
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $users = null;
        $floors = null;
        $prayer_types = null;

        if (!$floor) {
            $floors = Floor::all();
        } elseif ($floor && !$prayer_type) {
            $prayer_types = [["id" => 1, "name" => "Sabah Namazı"], ["id" => 2, "name" => "Öğle Namazı"], ["id" => 3, "name" => "İkindi Namazı"], ["id" => 4, "name" => "Akşam Namazı"], ["id" => 5, "name" => "Yatsı Namazı"]];
        } elseif ($floor && $prayer_type) {
            $users = User::where('floor_id', $floor)->get();
            foreach ($users as $user) {
                $user->attendance = Attendance::where('user_id', $user->id)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('prayer_type', $prayer_type)->first();
            }
        }


        if ($request->isMethod('post')) {
            $attendances = Attendance::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('prayer_type', $request->prayer_type)->get();
            $userIds = $request->user_id ?: [];
            foreach ($attendances as $attendance) {
                if (!in_array($attendance->user_id, $userIds)) {
                    $attendance->delete();
                } else {
                    $key = array_search($attendance->user_id, $userIds);
                    unset($userIds[$key]);
                }
            }

            foreach ($userIds as $user_id) {
                $attendance = new Attendance();
                $attendance->user_id = $user_id;
                $attendance->attendance_type = "prayer";
                $attendance->prayer_type = $request->prayer_type;
                $attendance->save();
            }


//                $attendance = new Attendance();
//                $attendance->user_id = $user_id;
//                $attendance->attendance_type = "prayer";
//                $attendance->prayer_type = $request->prayer_type;
//                $attendance->save();
        }

        return view('attendance.prayer', ['floors' => $floors, 'users' => $users, 'floor' => $floor, 'prayer_type' => $prayer_type, 'prayer_types' => $prayer_types]);

    }

    public function study(Request $request, $study_room = null)
    {
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        if (!$study_room)
            $study_rooms = StudyRooms::all();
        else
            $study_rooms = null;
        if ($study_room){
            $users = User::where('study_room', $study_room)->get();
            foreach ($users as $user) {
                $user->attendance = Attendance::where('user_id', $user->id)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('attendance_type', 'study')->first();
            }
        }
        else
            $users = null;

        $attendances = Attendance::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('attendance_type', 'study')->get();


        if ($request->isMethod('post')) {
            $userIds = $request->user_id ?: [];
            foreach ($attendances as $attendance) {
                if (!in_array($attendance->user_id, $userIds)) {
                    $attendance->delete();
                } else {
                    $key = array_search($attendance->user_id, $userIds);
                    unset($userIds[$key]);
                }
            }
            foreach ($userIds as $user_id) {
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
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        if (!$floor)
            $floors = Floor::all();
        else
            $floors = null;
        if (!$room)
            $rooms = Room::where('floor_id', $floor)->get();
        else
            $rooms = null;
        if ($room && $floor){
            $users = User::where('room', $room)->get();
            foreach ($users as $user) {
                $user->attendance = Attendance::where('user_id', $user->id)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('attendance_type', 'sleep')->first();
            }
        }
        else
            $users = null;

        $attendances = Attendance::where('attendance_type', 'sleep')->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->get();

        if ($request->isMethod('post')) {
            $userIds = $request->user_id ?: [];
            foreach ($attendances as $attendance) {
                if (!in_array($attendance->user_id, $userIds)) {
                    $attendance->delete();
                } else {
                    $key = array_search($attendance->user_id, $userIds);
                    unset($userIds[$key]);
                }
            }

            foreach ($userIds as $user_id) {
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
