<?php

namespace App\Http\Controllers;

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

    public function edit_user($user_id=null)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }
        if (!$user_id){
            echo "<a href='" . route("admin.users") . "'>Gerİ Dön</a>";
            return abort(403, "Kullanıcı ID'si belirtilmedi.");
        }
        $users = User::find($user_id);

        return view('admin.edit_user', ["users" => $users]);
    }
}
