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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate credentials and log in
        $request->authenticate();

        // Prevent session fixation
        $request->session()->regenerate();

        // Always go to cards after login
        return redirect()->intended(route('cards.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Fully reset session + CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('cards.index');
    }
}
