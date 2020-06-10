<?php

namespace App\Http\Middleware;

use Closure;

class isNotKiszallito
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
        if($request->user()->munkakor == 'Kiszállító') {
            return redirect()->route('home')->with('failure', ['Nincs jogosultsága az oldal megtekintéséhez']);
        }
        
        return $next($request);
    }
}
