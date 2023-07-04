<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DeleteController extends Controller
{
    public function attendances(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        DB::table('attendances')->truncate();

        return redirect()->route('admin.settings');
    }
    public function floors(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        DB::table('floors')->truncate();

        return redirect()->route('admin.settings');
    }
    public function rooms(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        DB::table('rooms')->truncate();

        return redirect()->route('admin.settings');
    }
    public function study_rooms(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        DB::table('study_rooms')->truncate();

        return redirect()->route('admin.settings');
    }
    public function users(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        DB::table('users')->truncate();

        return redirect()->route('admin.settings');
    }

    public function sessions(Request $request)
    {
        if (auth()->user()->rank != 100 && auth()->user()->rank != 0) {
            return redirect()->route('reports');
        }

        Session::flush();

        return redirect()->route('admin.settings');
    }
}
