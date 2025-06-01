<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountVerifiedMail;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('auth.login', $data);
    }

    public function action_login(Request $request)
    {
        // 1. Validasi input (sangat direkomendasikan)
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format alamat email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Coba autentikasi pengguna
        if (Auth::attempt($credentials)) {
            // Kredensial cocok, sekarang periksa status akun
            $user = Auth::user(); // Dapatkan instance pengguna yang terautentikasi

            // 3. Periksa status akun pengguna
            if ($user->status_akun == 'Aktif') {
                // Akun aktif, lanjutkan login
                $request->session()->regenerate(); // Regenerate session ID untuk keamanan
                return redirect()->intended(route('dashboard')); // Redirect ke dashboard atau halaman tujuan
            } else {
                // Akun tidak aktif
                Auth::logout(); // Logout pengguna karena Auth::attempt() sudah membuat sesi

                // Hapus session yang mungkin sudah dibuat dan regenerate token CSRF
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect kembali ke halaman login dengan pesan error spesifik
                return redirect()->route('login')
                    ->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }
        } else {
            // Kredensial (email atau password) tidak cocok
            return redirect()->route('login')
                ->with('error', 'Email atau password yang Anda masukkan salah.')
                ->withInput($request->only('email')); // Mengembalikan input email agar pengguna tidak perlu mengetik ulang
        }
    }

    public function register()
    {
        $data = [
            'title' => 'Register',
            'jurusans' => Jurusan::all(),
        ];

        return view('auth.register', $data);
    }

    public function action_register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'nim'        => 'required|string|unique:mahasiswas,nim|max:20',
            'jurusan_id' => 'required|exists:jurusans,id',
            'angkatan'   => 'required|integer|digits:4|min:2018|max:' . (date('Y') + 5),
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string'   => 'Nama lengkap harus berupa teks.',
            'name.max'      => 'Nama lengkap tidak boleh lebih dari :max karakter.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format alamat email tidak valid.',
            'email.unique'   => 'Alamat email ini sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.string'   => 'Password harus berupa teks.',
            'password.min'      => 'Password minimal harus :min 8 karakter.',

            'nim.required' => 'NIM wajib diisi.',
            'nim.string'   => 'NIM harus berupa teks.',
            'nim.unique'   => 'NIM ini sudah terdaftar.',
            'nim.max'      => 'NIM tidak boleh lebih dari :max 20 karakter.',

            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'jurusan_id.exists'   => 'Jurusan yang dipilih tidak valid.',

            'angkatan.required' => 'Angkatan wajib diisi.',
            'angkatan.integer'  => 'Angkatan harus berupa angka.',
            'angkatan.digits'   => 'Angkatan harus terdiri dari :digits digit angka (contoh: 2023).',
            'angkatan.min'      => 'Tahun angkatan minimal adalah :min.',
            'angkatan.max'      => 'Tahun angkatan maksimal adalah :max.',
        ]);

        // Memulai database transaction
        DB::beginTransaction();

        try {
            // 2. Buat dan simpan data ke tabel 'users'
            $user = User::create([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => bcrypt($request['password']), // Enkripsi password!
                'role'     => 'mahasiswa', // Misalnya, jika ada kolom role di tabel users
                'dummy_password' => $request['password'], // Simpan password asli jika diperlukan
                'status_akun' => 'Tidak Aktif', // Status akun awal
                // Jika ada field lain di tabel users yang perlu diisi, tambahkan di sini
                // contoh: 'role' => 'mahasiswa', (jika ada kolom role)
            ]);

            // 3. Buat dan simpan data ke tabel 'mahasiswas' dengan user_id dari user yang baru dibuat
            Mahasiswa::create([
                'user_id'    => $user->id, // Ambil ID dari user yang baru dibuat
                'nim'        => $request['nim'],
                'jurusan_id' => $request['jurusan_id'],
                'angkatan'   => $request['angkatan'],
                // Jika ada field lain di tabel mahasiswas yang perlu diisi, tambahkan di sini
            ]);

            // Jika semua proses berhasil, commit transaction
            DB::commit();

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Tunggu verifikasi akun anda.');
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaction
            DB::rollBack();

            // Opsional: Log error untuk debugging
            Log::error('Gagal menambahkan mahasiswa: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()
                ->withInput() // Mengembalikan input sebelumnya agar form terisi kembali
                ->with('error', 'Terjadi kesalahan saat menambahkan data mahasiswa. Silakan coba lagi.');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
