<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       //This is to check if the logged in user is an admin based on is_admin column in the database 
       if(auth()->user()->is_admin==1){
        return $next($request);
    }
    //If the user is not an admin then redirect him to the main page for clients
    return redirect('/tasks');
    }
}
