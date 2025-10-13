<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('form-login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input form login
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Data login valid (nim = password)
        $ValidUser = [
            'nim' => '2457301122',
            'password' => '2457301122',
        ];

        // Pengecekan username dan password
        if (
            $request->username == $ValidUser['nim'] &&
            $request->password == $ValidUser['password']
        ) {
            // Simpan session
            session(['username' => $request->username]);

            // Redirect ke dashboard dengan flash message
            return redirect('dashboard')->with('success', 'Selamat Datang Admin!');
        }

        // Jika gagal login
        return back()->with('error', 'Username atau password salah!');
    }

    /**
     * Tampilkan halaman register (GET)
     */
    public function showRegister()
    {
        return view('form-register');
    }

    /**
     * Proses pendaftaran (POST)
     */
    public function Register(Request $request)
    {
        $request->validate([
            'nama'             => ['required', 'regex:/^[^0-9]+$/'], // tidak boleh mengandung angka
            'alamat'           => 'required|max:300',
            'tanggal-lahir'    => 'required|date',
            'username'         => 'required|min:5',
            'password'         => [
                'required',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/', // minimal 1 huruf kapital dan 1 angka
            ],
            'confirm_password' => 'required|same:password',
        ], [
            'nama.regex'            => 'Nama tidak boleh mengandung angka.',
            'alamat.max'            => 'Alamat maksimal 300 karakter.',
            'password.regex'        => 'Password harus mengandung huruf kapital dan angka.',
            'confirm_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

       // 🔹 Redirect jika berhasil
        $isRegistered = true;

    if ($isRegistered) {
        // Jika berhasil
        return redirect()
            ->route('auth.index')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    } else {
        // Jika gagal
        return redirect()
            ->route('auth.showRegister')
            ->with('error', 'Registrasi Anda gagal. Silakan coba lagi.');
    }
}

        public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
