<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; 
use Illuminate\Support\Facades\Log;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        Log::info("Entramos en create.");
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            if (auth()->user()->isVoluntario()) {
                return redirect()->route('voluntario_logeado.index');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            // Comprobar si el correo electrónico proporcionado está registrado en el sistema
            $userExists = User::where('email', $credentials['email'])->exists();
    
            if (!$userExists) {
                return redirect()->back()->withErrors([
                    'email' => 'El correo electrónico proporcionado no está registrado en nuestro sistema.',
                ]);
            } else {
                // Si el intento de autenticación falla debido a una contraseña incorrecta
                return redirect()->back()->withErrors([
                    'password' => 'La contraseña proporcionada es incorrecta.',
                ]);
            }
        }
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
