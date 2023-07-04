<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Room;
use App\Models\StudyRooms;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        return view('admin.home', []);
    }

    public function users()
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
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
        if (!$user_id) {
            echo "<a href='" . route("admin.users") . "'>Gerİ Dön</a>";
            return abort(403, "Kullanıcı ID'si belirtilmedi.");
        }
        $user = User::find($user_id);

        if ($request && $request->id == $user->id) {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->room = $request->room;
            $user->floor_id = $request->floor;
            $user->study_room = $request->study_room;
            $user->rank = $request->rank;
            $user->save();
            return redirect()->route('admin.users');
        }

        return view('admin.edit_user', ["user" => $user]);
    }

    public function add_user(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        if ($request->name) {
            if (User::where('username', $request->username)->first()) {
                return abort(403, "Bu T.C. kimlik numarası zaten kullanılıyor.");
            }
            if (!$request->password) {
                $password = $request->username;
            }else{
                $password = $request->password;
            }
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->room = $request->room;
            $user->floor_id = $request->floor;
            $user->study_room = $request->study_room;
            $user->rank = $request->rank;
            $user->password = bcrypt($password);
            $user->open_password = $password;
            $user->save();
            return redirect()->route('admin.users');
        }

        return view('admin.add_user', []);
    }

    public function delete_user(Request $request, $user_id)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        $delete = User::find($user_id)->delete();
        if ($delete) {
            return redirect()->route('admin.users');
        } else {
            return abort(403, "Kullanıcı silinemedi.");
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
                if ($request->room == $key->id) {
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

    public function delete_study_room(Request $request, $study_room=null)
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

    public function settings()
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        return view('admin.settings', []);
    }
}
