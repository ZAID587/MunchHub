<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            ],
            'apellido' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                'unique:'.User::class,
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El nombre solo debe contener letras.',
            'apellido.regex' => 'El apellido solo debe contener letras.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.alpha_dash' => 'El nombre de usuario solo puede contener letras, números y guiones.',
            'username.unique' => 'Este nombre de usuario ya está registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo es inválido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'apellido' => $request->filled('apellido') ? trim($request->apellido) : null,
            'username' => trim($request->username),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => 'cliente',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('client.inicio')->with('welcome_new_user', true);
    }
}
