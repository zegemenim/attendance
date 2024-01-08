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

        $users_grouped = null;
        $floors = null;
        $prayer_types = null;

        if (!$floor) {
            $floors = Floor::all();
        } elseif ($floor && !$prayer_type) {
            $prayer_types = [["id" => 1, "name" => "Sabah Namazı"], ["id" => 2, "name" => "Öğle Namazı"], ["id" => 3, "name" => "İkindi Namazı"], ["id" => 4, "name" => "Akşam Namazı"], ["id" => 5, "name" => "Yatsı Namazı"]];
        } elseif ($floor && $prayer_type) {
//            $users = User::where('floor_id', $floor)->get();
            $users = User::where('rank', ">=", 300)->orderBy('room')->get();

            foreach ($users as $key => $user) {
                if (Room::where("id", $user->room)->first()->floor_id == $floor) {
                    $user->attendance = Attendance::where('user_id', $user->id)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('prayer_type', $prayer_type)->first();
                } else {
                    $user->attendance = null;
                    unset($users[$key]);
                }
            }
            $users_grouped = [];
            // Group users by room
            foreach ($users as $user) {
                $users_grouped[$user->room][] = $user;
            }
        }


        if ($request->isMethod('post')) {
            $attendances = Attendance::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('prayer_type', $request->prayer_type)->get();
            $attendances_new = [];
            foreach ($attendances as $attendance) {
                $user_room = User::where('id', $attendance->user_id)->first()->room;
                if (Room::where("id", $user_room)->first()->floor_id == $floor)
                    $attendances_new[] = $attendance;
            }
            $userIds = $request->user_id ?: [];
            foreach ($attendances_new as $attendance) {
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
        }

        if ($request->isMethod("post"))
            return redirect()->route('attendance.prayer');



        return view('attendance.prayer', ['floors' => $floors, 'users_grouped' => $users_grouped, 'floor' => $floor, 'prayer_type' => $prayer_type, 'prayer_types' => $prayer_types]);

    }

    public function study(Request $request, $study_type = null, $study_room = null)
    {
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        if (!$study_type) {
            $study_types = [["id" => 1], ["id" => 2]];
            $study_rooms = null;
        } elseif (!$study_room) {
            $study_rooms = StudyRooms::all();
            $study_types=null;
        } else {
            $study_rooms = null;
            $study_types = null;
        }
        if ($study_room) {
            $users = User::where('study_room', $study_room)->where('rank', ">=", 300)->get();
            foreach ($users as $user) {
                $user->attendance = Attendance::where('user_id', $user->id)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('attendance_type', 'study')->where('study_type', $study_type)->first();
            }
        } else
            $users = null;

        $attendances = Attendance::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('attendance_type', 'study')->where('study_type', $study_type)->get();
        $attendances_new = [];
        foreach ($attendances as $attendance) {
            $user_room = User::where('id', $attendance->user_id)->first()->study_room;
            if ($user_room == $study_room)
                $attendances_new[] = $attendance;
        }

        if ($request->isMethod('post')) {
            $study_type = $request->study_type;
            $userIds = $request->user_id ?: [];
            foreach ($attendances_new as $attendance) {
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
                $attendance->study_type = $study_type;
                $attendance->save();
            }
        }

        if ($request->isMethod("post"))
            return redirect()->route('attendance.study');

        return view('attendance.study', ['study_rooms' => $study_rooms, 'users' => $users, 'study_room' => $study_room, 'study_type' => $study_type, 'study_types' => $study_types]);
    }

    public function sleep(Request $request, $floor = null)
    {
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        if (!$floor){
            $floors = Floor::all();
            $users_grouped = [];
        }
        else
            $floors = null;
//        if (!$room)
//            $rooms = Room::where('floor_id', $floor)->get();
//        else
//            $rooms = null;
        if ($floor) {
            $users = User::where('rank', ">=", 300)->orderBy('room')->get();
            $users_new = [];
            foreach ($users as $user) {
                $user->floor = Room::where('id', $user->room)->first()->floor_id;
                if (strval($user->floor) == strval($floor))
                    array_push($users_new, $user);
                $user->attendance = Attendance::where('user_id', $user->id)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->where('attendance_type', 'sleep')->first();
            }
            $users_grouped = [];
            // Group users by room
            foreach ($users_new as $user) {
                $users_grouped[$user->room][] = $user;
            }


        } else
            $users = null;

        $attendances = Attendance::where('attendance_type', 'sleep')->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->get();
        $attendances_new = [];
        foreach ($attendances as $attendance) {
                $user_floor = Room::where('id', User::where('id', $attendance->user_id)->first()->room)->first()->floor_id;
            if ($user_floor == $floor)
                $attendances_new[] = $attendance;
        }

        if ($request->isMethod('post')) {
            $userIds = $request->user_id ?: [];
            foreach ($attendances_new as $attendance) {
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
            return redirect()->route('attendance.sleep');

        return view('attendance.sleep', ['floors' => $floors, 'floor' => $floor, 'users_grouped' => $users_grouped]);
    }
}
