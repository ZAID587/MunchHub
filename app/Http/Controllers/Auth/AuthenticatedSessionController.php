<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request for clients.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        Auth::logoutOtherDevices($request->password);

        // Si el usuario es Administrador, exigir estrictamente el código PIN de seguridad
        if (Auth::user()->isAdmin()) {
            $securityCode = DB::table('admin_settings')
                ->where('key_name', 'admin_security_code')
                ->value('value') ?? '1720';

            $inputCode = trim($request->input('admin_code', ''));

            if (empty($inputCode) || $inputCode !== $securityCode) {
                $email = Auth::user()->email;
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->withInput(['email' => $email])->withErrors([
                    'admin_code' => 'Esta cuenta pertenece al Administrador. Debes ingresar obligatoriamente el código PIN de verificación para acceder.',
                ]);
            }

            $request->session()->put('admin_verified', true);
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('client.inicio', absolute: false));
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Handle an incoming authentication request for administrators.
     * Enforces the admin security code (default: 1720).
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'admin_code' => ['required', 'string'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'admin_code.required' => 'El código de verificación de administrador es obligatorio.',
        ]);

        // Verificar código de seguridad especial de administrador (1720)
        $securityCode = DB::table('admin_settings')
            ->where('key_name', 'admin_security_code')
            ->value('value') ?? '1720';

        if (trim($request->input('admin_code')) !== $securityCode) {
            return back()->withInput($request->only('email'))->withErrors([
                'admin_code' => 'El código de verificación de administrador no es válido. Acceso denegado.',
            ]);
        }

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
        }

        $request->session()->regenerate();
        Auth::logoutOtherDevices($request->password);

        if (!Auth::user()->isAdmin()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/admin/login')->withErrors([
                'email' => 'Acceso denegado. Tu cuenta no cuenta con privilegios de administrador.',
            ]);
        }

        $request->session()->put('admin_verified', true);

        return redirect()->intended(route('admin.dashboard', absolute: false));
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
