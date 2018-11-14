<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Redirect;
use View;

class CheckLoggedIn {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
			if(!Session::has('user_id')){
			 	return redirect('/');
			}
		return $next($request);
	}
}
