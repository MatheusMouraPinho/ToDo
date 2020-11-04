<?php

namespace App\Http\Middleware;
use Closure;

class avaliador //classe que é puxada no kernel depois
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
        if(auth()->user()->avaliador()) {   //função do User.php
            return $next($request);
        }
        return redirect('home');
    }
}