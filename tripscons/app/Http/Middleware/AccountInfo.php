<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccountInfo
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
            if (empty(Auth::user()->name))
                return redirect()->route('account_info');

        return $next($request);
    }
}
