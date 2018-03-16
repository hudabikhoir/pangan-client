<?php

namespace App\Http\Middleware;

use Closure;

class CekStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \App\User::where('email', $request->email)->first();
        // dd($user);
        if ($user->id_role === '1') {
            return redirect('/home');
        } elseif ($user->id_role === '2') {
            return redirect('/home-petani');
        }
        return $next($request);
    }
}
