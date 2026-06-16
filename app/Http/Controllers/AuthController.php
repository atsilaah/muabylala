<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller {
    public function loginForm() {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => true])) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors(['email' => 'Email/password salah atau akun tidak aktif.'])->withInput();
    }

    public function registerForm() {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);
        return redirect()->route('customer.dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function lupaPassword() {
        return view('auth.lupa-password');
    }

    public function kirimReset(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);
        return back()->with('success', 'Link reset password telah dikirim ke email kamu!');
    }

    private function redirectByRole() {
        return match(Auth::user()->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'mua'      => redirect()->route('mua.dashboard'),
            default    => redirect()->route('customer.dashboard'),
        };
    }
}
