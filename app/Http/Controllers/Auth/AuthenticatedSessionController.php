<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('authentication.login');
        // return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // dd(
        //     $request->user()->role,
        //     $request->user()
        // );


        // return redirect()->intended(route('dashboard', absolute: false));

        // admin route
        if( $request->user()->role == 'admin' || $request->user()->role == 'superadmin')
            {
                return to_route('adminHome');
            }

        // User & Teacher Route
        if(  $request->user()->role == 'user' || $request->user()->role == 'teacher')
        {
            return to_route('userHome');
        }

        // default
        return to_route('login');

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
