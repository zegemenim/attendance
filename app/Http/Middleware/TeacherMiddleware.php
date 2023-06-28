<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd("TeacherMiddleware");
        if (Auth::check()) {
            $user_rank = auth()->user()->rank;
            print_r($user_rank);
            if ($user_rank == 200 || $user_rank == 100 || $user_rank == 0)
                return $next($request);
            elseif ($user_rank == 300)
                return redirect()->route('home');
            else
                return redirect()->route('login');
        }
        return $next($request);
    }
}
