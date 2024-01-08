<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Floor;
use App\Models\Room;
use App\Models\StudyRooms;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = [];
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        $user_id = request()->query('user_id');

        if ($user_id)
            $user = User::find($user_id);
        else {
            $user = null;
            $users = User::where('rank', ">=", 300)->get();
        }
        if ($user)
            $attendances = Attendance::where('user_id', $user->id)->where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->get();
        else
            $attendances = [];

        $dates = [];
        $slug = request()->query('type');
        $attendances = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dates[] = $date;
        }

        if ($slug == "prayer") {
            $attendances_old = Attendance::where('user_id', $user_id)->where('attendance_type', 'prayer')->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))->get();
            foreach ($attendances_old as $attendance_old) {
                $attendances[] = [$attendance_old->prayer_type, $attendance_old->created_at->format('Y-m-d')];
            }
        } elseif ($slug == "study") {
            $attendances_old = Attendance::where('user_id', $user_id)->where('attendance_type', 'study')->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))->get("created_at");
            foreach ($attendances_old as $attendance_old) {
                $attendances[] = $attendance_old->created_at->format('Y-m-d');
            }
        } elseif ($slug == "sleep") {
            $attendances_old = Attendance::where('user_id', $user_id)->where('attendance_type', 'sleep')->where('created_at', '>=', date('Y-m-d', strtotime("-30 days")))->get("created_at");
            foreach ($attendances_old as $attendance_old) {
                $attendances[] = $attendance_old->created_at->format('Y-m-d');
            }
        }
        if ($request->date) {
            $date = $request->date;
        } else {
            $date = date("Y-m-d", strtotime('-1 day'));
        }

        return view('admin.home', ['attendances' => $attendances, 'dates' => $dates, 'slug' => $slug, 'user_id' => $user_id, 'user' => $user, 'users' => $users, "time" => $date]);
    }

    public function users()
    {
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $users = User::all();

        return view('admin.users', ["users" => $users]);
    }

    public function edit_user(Request $request, $user_id = null)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        $rooms = Room::all();
        $study_rooms = StudyRooms::all();
        if (!$user_id) {
            echo "<a href='" . route("admin.users") . "'>Gerİ Dön</a>";
            return abort(403, "Kullanıcı ID'si belirtilmedi.");
        }
        $user = User::find($user_id);

        if ($request && $request->id == $user->id) {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->room = $request->room;
            $user->study_room = $request->study_room;
            $user->rank = $request->rank;
            $user->save();
            return redirect()->route('admin.users');
        }

        return view('admin.edit_user', ["user" => $user, "rooms" => $rooms, "study_rooms" => $study_rooms]);
    }

    public function add_user(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        $rooms = Room::all();
        $study_rooms = StudyRooms::all();
        $floors = Floor::all();

        if ($request->name) {
            if (User::where('username', $request->username)->first()) {
                return abort(403, "Bu T.C. kimlik numarası zaten kullanılıyor.");
            }
            if (!$request->password) {
                $password = $request->username;
            } else {
                $password = $request->password;
            }

            if ($floor = Room::where("id", $request->room)->first()->floor_id) {
                $floor_id = Floor::find($floor)->id;
            } else {
                abort(403, "Oda bulunamadı.");
            }
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->room = $request->room;
            $user->study_room = $request->study_room;
            $user->rank = $request->rank;
            $user->password = bcrypt($password);
            $user->open_password = $password;
            $user->save();
            return redirect()->route('admin.users');
        }

        return view('admin.add_user', ['rooms' => $rooms, 'floors' => $floors, 'study_rooms' => $study_rooms]);
    }

    public function delete_user(Request $request, $user_id)
    {
        if (auth()->user()->rank > 100) {
            return redirect()->route('reports');
        }

        $delete = User::find($user_id);

        if ($delete) {
            $delete->delete();    
        }else {
            return abort(403, "Kullanıcı bulunamadı.");
        }

        
    }

    public function rooms(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $rooms = Room::all();

        return view('admin.rooms', ["rooms" => $rooms]);
    }

    public function add_room(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        $floors = Floor::all();
        if ($request->floor) {
            $room = new Room();
            $room->id = $request->room;
            $room->floor_id = $request->floor;
            $room->save();
            return redirect()->route('admin.rooms');
        } else {
            return view('admin.add_room', ["floors" => $floors]);
        }
    }

    public function edit_room(Request $request, $room_id = null)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        if (!$room_id) {
            echo "<a href='" . route("admin.users") . "'>Gerİ Dön</a>";
            return abort(403, "Kullanıcı ID'si belirtilmedi.");
        }
        $rooms = Room::all();
        $room = Room::find($room_id);
        $floors = Floor::all();

        if ($request->floor) {
            foreach ($rooms as $key) {
                if ($request->room == $key->id && $request->floor == $key->floor_id) {
                    return abort(403, "Oda zaten var.");
                }
            }

            $room->id = $request->room;
            $room->floor_id = $request->floor;
            $room->save();
            return redirect()->route('admin.rooms');
        }

        return view('admin.edit_room', ["room" => $room, "floors" => $floors]);
    }

    public function delete_room(Request $request, $room_id)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $delete = Room::find($room_id)->delete();
        if ($delete) {
            return redirect()->route('admin.rooms');
        } else {
            return abort(403, "Oda silinemedi.");
        }
    }

    public function floors(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $floors = Floor::all();

        return view('admin.floors', ["floors" => $floors]);
    }

    public function add_floor(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        if ($request->floor) {
            $floors = Floor::all();
            foreach ($floors as $key) {
                if ($request->floor == $key->id) {
                    return abort(403, "Kat zaten var.");
                }
            }
            $floor = new Floor();
            $floor->id = $request->floor;
            $floor->save();
            return redirect()->route('admin.floors');
        } else {
            return view('admin.add_floor', []);
        }
    }

    public function edit_floor(Request $request, $floor_id = null)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        if (!$floor_id) {
            echo "<a href='" . route("admin.floors") . "'>Geri Dön</a>";
            return abort(403, "Kat ID'si belirtilmedi.");
        }
        $floor = Floor::find($floor_id);
        $floors = Floor::all();

        if ($request->floor) {
            foreach ($floors as $key) {
                if ($request->floor == $key->id) {
                    return abort(403, "Kat zaten var.");
                }
            }

            $floor->id = $request->floor;
            $floor->save();
            return redirect()->route('admin.floors');
        }

        return view('admin.edit_floor', ["floor" => $floor, "floors" => $floors]);
    }

    public function delete_floor(Request $request, $floor_id)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $delete = Floor::find($floor_id)->delete();
        if ($delete) {
            return redirect()->route('admin.floors');
        } else {
            return abort(403, "Oda silinemedi.");
        }
    }

    public function study_rooms(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $study_rooms = StudyRooms::all();

        return view('admin.study_rooms', ["study_rooms" => $study_rooms]);
    }

    public function add_study_room(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $study_rooms = StudyRooms::all();

        if ($request->study_room) {
            foreach ($study_rooms as $key) {
                if ($request->study_room == $key->id) {
                    return abort(403, "Oda zaten var.");
                }
            }
            $study_room = new StudyRooms();
            $study_room->id = $request->study_room;
            $study_room->save();
            return redirect()->route('admin.study_rooms');
        } else {
            return view('admin.add_study_room', []);
        }
    }

    public function edit_study_room(Request $request, $study_room = null)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        if (!$study_room) {
            echo "<a href='" . route("admin.study_rooms") . "'>Geri Dön</a>";
            return abort(403, "Oda ID'si belirtilmedi.");
        }
        $study_room = StudyRooms::find($study_room);
        $study_rooms = StudyRooms::all();

        if ($request->study_room) {
            foreach ($study_rooms as $key) {
                if ($request->study_room == $key->id) {
                    return abort(403, "Çalışma odası zaten var.");
                }
            }

            $study_room->id = $request->study_room;
            $study_room->save();
            return redirect()->route('admin.study_rooms');
        }

        return view('admin.edit_study_room', ["study_room" => $study_room, "study_rooms" => $study_rooms]);
    }

    public function delete_study_room(Request $request, $study_room = null)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $delete = StudyRooms::find($study_room)->delete();
        if ($delete) {
            return redirect()->route('admin.study_rooms');
        } else {
            return abort(403, "Oda silinemedi.");
        }
    }

    public function settings(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        $announcement = \App\Models\Data::first();
        if ($request->announcement) {
            $announcement->title = $request->title;
            $announcement->announcement = $request->announcement;
            $announcement->save();
            return redirect()->route('admin.settings');
        }

        return view('admin.settings', ["announcement" => $announcement]);
    }

    public function get_excel(Request $request)
    {
        if (auth()->user()->rank != 200 && auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        if ($request->date) {
            $date = $request->date;
        } else {
            $date = date("Y-m-d", strtotime('-1 day'));
        }

//        $attendances = Attendance::where('created_at', '>=', $date . " 00:00:00")->where('created_at', '<=', $date . " 23:59:59")->get();
        $users = User::where('rank', '>=', 300)->get()->sortBy('room');
        foreach ($users as $user) {
            $attendances = Attendance::where('user_id', $user->id)->where('created_at', '>=', $date . " 00:00:00")->where('created_at', '<=', $date . " 23:59:59")->get();

            foreach ($attendances as $attendance) {
                if ($attendance->attendance_type == "prayer" && $attendance->prayer_type == 1) {
                    $user->prayer1 = $attendance->created_at->format('H:i:s');
                } elseif ($attendance->attendance_type == "prayer" && $attendance->prayer_type == 2) {
                    $user->prayer2 = $attendance->created_at->format('H:i:s');
                } elseif ($attendance->attendance_type == "prayer" && $attendance->prayer_type == 3) {
                    $user->prayer3 = $attendance->created_at->format('H:i:s');
                } elseif ($attendance->attendance_type == "prayer" && $attendance->prayer_type == 4) {
                    $user->prayer4 = $attendance->created_at->format('H:i:s');
                } elseif ($attendance->attendance_type == "prayer" && $attendance->prayer_type == 5) {
                    $user->prayer5 = $attendance->created_at->format('H:i:s');
                } elseif ($attendance->attendance_type == "study" && $attendance->study_type == 1) {
                    $user->study1 = $attendance->created_at->format('H:i:s');
                } elseif ($attendance->attendance_type == "study" && $attendance->study_type == 2) {
                    $user->study2 = $attendance->created_at->format('H:i:s');
                } elseif ($attendance->attendance_type == "sleep") {
                    $user->sleep = $attendance->created_at->format('H:i:s');
                }
            }
        }

        $rooms_new = [];
        foreach ($users as $user) {
            $rooms_new[$user->room][] = $user;
        }

        return view('admin.get_excel', ["users" => $rooms_new, "time" => $date]);
    }
}
