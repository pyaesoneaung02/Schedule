<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'teacher') {
            if (auth()->user()->role == 'superadmin') {
                return redirect()->route('adminHome');
            }

            // User / Teacher cannot access admin
            return redirect()->route('userHome');
        }

        return $next($request);
    }
}
