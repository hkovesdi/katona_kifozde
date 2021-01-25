<?php

namespace App\Http\Middleware;

use Closure;

class isFonokOrTitkarno
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
        if($request->user()->munkakor == 'Főnök' || $request->user()->munkakor == 'Titkárnő') {
            return $next($request);
        }
        
        return redirect()->route('home')->with('failure', ['Nincs jogosultsága az oldal megtekintéséhez']);
    }
}
