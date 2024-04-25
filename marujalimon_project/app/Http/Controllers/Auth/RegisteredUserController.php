<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Coordinador;
use App\Models\User;
use App\Models\Voluntario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

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


        $role = $request->input('role');



        if ($role === 'coordinador') {
            // El usuario es un coordinador
            $is_coordinador = true;
            $is_admin = false;
            Log::info('Role1: ' . $role);




        } elseif ($role === 'administrador') {





            $is_coordinador = false;
            $is_admin = true;
        } elseif ($role === 'voluntario') {





            $is_coordinador = false;
            $is_admin = false;
            $is_voluntario = true;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_coordinador' => $is_coordinador,
            'is_admin' => $is_admin,
            'is_voluntario' => $is_voluntario,
        ]);
        // Si el usuario es coordinador, crear un coordinador asociado a él
        if ($user->is_coordinador) {


            $coordinador = new Coordinador([
                'COO_nombre' => $user->name,
                'COO_dni' => $request->dni, // Asignar el DNI proporcionado por el usuario
                'COO_mail' => $request->email,
            ]);
            $user->coordinador()->save($coordinador);
        } if ($user->is_voluntario) {
            $voluntarioData = [
                'VOL_nombre' => $request->name,
                'VOL_dni' => $request->dni,
                'VOL_mail' => $request->email,
            ];
            $voluntario = new Voluntario($voluntarioData);


            Log::info('Voluntario: ' . $voluntario);

            $user->voluntario()->save($voluntario);

            event(new Registered($user));

            Auth::login($user);


            return redirect()->route('voluntario_logeado.index', ['voluntario'=>$voluntario]);

        }
            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('dashboard');



    }
}
