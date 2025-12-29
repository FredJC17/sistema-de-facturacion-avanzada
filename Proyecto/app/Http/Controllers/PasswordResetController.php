<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Mostrar formulario para solicitar código
     */
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Enviar código de recuperación por email
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);

        // Buscar usuario por email o documento
        $user = Cliente::where('email', $request->email)
            ->orWhere('documento', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'No se encontró ninguna cuenta con ese correo o documento.');
        }

        // Generar código de 6 dígitos
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Eliminar tokens anteriores del usuario
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Guardar nuevo token
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $code,
            'created_at' => now(),
        ]);

        // Enviar email
        try {
            Mail::send('emails.password-reset', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Código de Recuperación de Contraseña - SFA');
            });

            // Guardar email en sesión persistente
            session(['email' => $user->email]);

            return redirect()->route('password.code.form')
                ->with('success', 'Se ha enviado un código de verificación a tu correo electrónico.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar el correo. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Mostrar formulario para ingresar código
     */
    public function showCodeForm()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.code');
    }

    /**
     * Verificar código ingresado
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $email = session('email');
        
        $reset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $request->code)
            ->first();

        if (!$reset) {
            return back()->with('error', 'El código ingresado es incorrecto.');
        }

        // Verificar si el código no ha expirado (15 minutos)
        $createdAt = Carbon::parse($reset->created_at);
        if ($createdAt->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->with('error', 'El código ha expirado. Por favor, solicita uno nuevo.');
        }

        // Guardar en sesión explícitamente para el siguiente paso
        session(['email' => $email, 'token' => $request->code]);

        // Redirigir a formulario de nueva contraseña
        return redirect()->route('password.reset.form');
    }

    /**
     * Mostrar formulario para nueva contraseña
     */
    public function showResetForm()
    {
        if (!session('email') || !session('token')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.reset');
    }

    /**
     * Actualizar contraseña
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('email');
        $token = session('token');

        // Verificar que el token todavía existe
        $reset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return redirect()->route('password.request')
                ->with('error', 'Token inválido o expirado.');
        }

        // Actualizar contraseña
        $user = Cliente::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar token usado
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Limpiar sesión
        session()->forget(['email', 'token']);

        return redirect()->route('login')
            ->with('success', '¡Contraseña actualizada correctamente! Ahora puedes iniciar sesión.');
    }

    /**
     * Reenviar código
     */
    public function resendCode()
    {
        $email = session('email');
        
        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = Cliente::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request');
        }

        // Generar nuevo código
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Actualizar token
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $code,
            'created_at' => now(),
        ]);

        // Reenviar email
        try {
            Mail::send('emails.password-reset', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Código de Recuperación de Contraseña - SFA');
            });

            return back()->with('success', 'Se ha reenviado un nuevo código a tu correo electrónico.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al reenviar el correo.');
        }
    }
}
