<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages/auth/login');
    }

    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerate session ID untuk keamanan tambahan
            $request->session()->regenerate();

            // Redirect ke halaman home dengan pesan sukses
            if(Auth::user()->role == 'admin') {
                return redirect()->route('dashboard.index')->with('success', 'Anda berhasil login.');
            }
            
            return redirect()->route('home.index')->with('success', 'Anda berhasil login.');
        }

        // Kembalikan ke halaman login dengan pesan error dan input email tetap terisi
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->withInput($request->only('email'));
    }

    public function register()
    {
        return view('pages/auth/register');
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'email.required' => 'Email harus diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Email harus dalam format yang benar.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password harus minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($data);

        Auth::login($user);

        return redirect()->route('home.index')->with('success', 'Anda telah berhasil mendaftar.');
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
