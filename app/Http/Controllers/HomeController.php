<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $dates = [];
        $slug = $request->segment(1);
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

        return view('reports', ['attendances' => $attendances, 'dates' => $dates, 'slug' => $slug, 'user_id' => $user_id]);
    }
}
