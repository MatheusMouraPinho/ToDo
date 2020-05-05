<?php


namespace App\Http\Middleware;
use Closure;
use Auth;


class Altoriza //classe que é puxada no kernel depois
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
        if(auth()->user()->Altoriza()) {   //função do User.php
            return $next($request);
        }
        return response()->view('auth.aviso');
    }
}