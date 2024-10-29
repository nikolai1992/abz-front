<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class TokenExistMiddleware
{
	public function handle(Request $request, Closure $next)
	{
        $abzToken = Session::get('abz_token');

        if ($abzToken) {
            return $next($request);
        } else {
            Session::flash('error_message', 'Invalid token. Try to get a new one by the method GET api/v1/token.');
            return redirect()->route('main.page');
        }
	}
}
