<?php

namespace App\Http\Middleware;

use Closure;

class ForceHttpProtocol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri(), 301); // ← ここを変更しました
        }

        return $next($request);
    }
}
