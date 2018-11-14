<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Redirect;
use View;
use DB;

class CheckGAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(Session::has('user_id')){
			$user_id=Session::get("user_id");
			$auth_skip = DB::table('users')->where('id',$user_id)->first(['AUTH_skip','G_AUTH','is_gAuth']);
	        if((isset($auth_skip) && !empty($auth_skip)) && ($auth_skip->G_AUTH == 1 || $auth_skip->AUTH_skip == 1)){
	            if($auth_skip->G_AUTH == 1 && $auth_skip->is_gAuth != 1 ){
	                return redirect("user_authent");
	            }else{
	        		return $next($request);    	
	            }            
	        }   
		}else{
			return redirect("/");
		}
	}
}
