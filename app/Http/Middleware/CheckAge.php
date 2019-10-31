<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class CheckAge
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
      if (!$request->session()->has('key')) {
            $value = $request->session()->get('key');
        dd($value);
        }
    }
}
