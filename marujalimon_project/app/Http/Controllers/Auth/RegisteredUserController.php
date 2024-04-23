<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Coordinador;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register-v3');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dni' => ['required', 'string', 'max:255'], // Validar el campo del DNI
        ]);


        $role = $request->role;

        if ($role === 'coordinador') {
            // El usuario es un coordinador
            $is_coordinador = true;
            $is_admin = false;
        } elseif ($role === 'administrador') {
            // El usuario es un administrador
            $is_coordinador = false;
            $is_admin = true;
        } else {
            // Manejar el caso en el que no se selecciona ningún rol
            $is_coordinador = false;
            $is_admin = false;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_coordinador' => $is_coordinador,
            'is_admin' => $is_admin,
        ]);
        // Si el usuario es coordinador, crear un coordinador asociado a él
        if ($user->is_coordinador) {
            $coordinador = new Coordinador([
                'COO_nombre' => $user->name,
                'COO_dni' => $request->dni, // Asignar el DNI proporcionado por el usuario
            ]);
            $user->coordinador()->save($coordinador);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
