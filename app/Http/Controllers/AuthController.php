<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * AuthController
 * 
 * Handle semua yang berhubungan dengan autentikasi user:
 * - Login & Logout
 * - Register user baru
 * - Role-based redirect (Admin ke dashboard, User ke home)
 */
class AuthController extends Controller
{
    // ========================================
    // LOGIN
    // ========================================

    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login user
     * 
     * Flow:
     * 1. Validasi email & password
     * 2. Coba authenticate dengan remember me option
     * 3. Kalau berhasil, cek role user:
     *    - Admin redirect ke /admin
     *    - User biasa redirect ke /
     * 4. Kalau gagal, balik ke form dengan error message
     */
    public function login(Request $request)
    {
        // Validasi input email & password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login dengan credentials, dan cek checkbox "remember me"
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session buat keamanan (prevent session fixation)
            $request->session()->regenerate();

            // Cek role user setelah berhasil login
            // Kalau admin, arahkan ke admin dashboard
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Kalau user biasa, arahkan ke home
            return redirect()->intended(route('home'));
        }

        // Kalau gagal login, balik ke form dengan error message
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // ========================================
    // REGISTER
    // ========================================

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru
     * 
     * Flow:
     * 1. Validasi semua input (name, email, phone, password, terms)
     * 2. Hash password pakai bcrypt
     * 3. Set role default = 'user' (bukan admin)
     * 4. Redirect ke halaman login dengan success message
     */
    public function register(Request $request)
    {
        // Validasi input user
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'], // Harus setuju T&C
        ]);

        // Buat user baru dengan role default 'user'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), // Hash password buat keamanan
            'role' => 'user', // Role default untuk user biasa (bukan admin)
        ]);

        // Sengaja gak auto-login setelah register
        // Biar user harus login manual dulu
        // Auth::login($user);

        // Redirect ke login dengan pesan sukses
        return redirect(route('login'))->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
    }

    // ========================================
    // LOGOUT
    // ========================================

    /**
     * Logout user
     * 
     * Flow:
     * 1. Logout dari Auth facade
     * 2. Invalidate session (hapus semua data session)
     * 3. Regenerate CSRF token
     * 4. Redirect ke home
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session buat keamanan
        $request->session()->invalidate();
        
        // Regenerate token biar session lama gak bisa dipakai lagi
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
