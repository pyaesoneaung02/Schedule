<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);

        // if (Auth::user()->role == 'user') {
        //     return $next($request);
        // }

        // return back();

        if (!Auth::check()) {
                return redirect()->route('login');
            }

            if (Auth::user()->role == 'user') {

                if (str_contains($request->path(), 'admin')) {
                    return back();
                }

                if (
                    $request->route()->getName() == 'login' ||
                    $request->route()->getName() == 'register'
                ) {
                    return back();
                }

                return $next($request);
            }

            return back();
        }
    }

