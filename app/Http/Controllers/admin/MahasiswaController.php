<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountVerifiedMail;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with('users', 'jurusans')->whereHas('users', function ($query) {
            $query->where('status_akun', 'Aktif');
        })->get();

        $data = [
            'title' => 'Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'no' => 1,
        ];

        return view('admin.mahasiswa.index', $data);
    }

    // Other methods for MahasiswaController can be added here

    public function create()
    {
        $data = [
            'title' => 'Tambah Mahasiswa',
            'jurusans' => Jurusan::all(),
        ];

        return view('admin.mahasiswa.create', $data);
    }

    public function store(Request $request)
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

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
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

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('users', 'jurusans')->findOrFail($id);

        $data = [
            'title' => 'Edit Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'jurusans' => Jurusan::all(),
        ];

        return view('admin.mahasiswa.update', $data);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'password'   => 'nullable|string|min:8', // Password bisa diisi atau tidak
            'nim'        => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'jurusan_id' => 'required|exists:jurusans,id',
            'angkatan'   => 'required|integer|digits:4|min:2018|max:' . (date('Y') + 5),
            'status_akun' => 'required|in:Aktif,Tidak Aktif', // Tambahkan validasi untuk status akun
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

            'status_akun.required' => 'Status akun wajib dipilih.',
            'status_akun.in'      => 'Status akun harus salah satu dari: Aktif, Tidak Aktif.',
        ]);

        // Memulai database transaction
        DB::beginTransaction();

        try {
            // Update data di tabel users
            $user = User::findOrFail($mahasiswa->user_id);
            $user->update([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => $request['password'] ? bcrypt($request['password']) : $user->password, // Enkripsi password jika diisi
                'status_akun' => $request['status_akun'], // Update status akun
                'dummy_password' => $request['password'] ?? $user->dummy_password, // Simpan password asli jika diperlukan
                // Jika ada field lain yang perlu diupdate, tambahkan di sini
            ]);

            // Update data di tabel mahasiswas
            $mahasiswa->update([
                'nim'        => $request['nim'],
                'jurusan_id' => $request['jurusan_id'],
                'angkatan'   => $request['angkatan'],
                // Jika ada field lain yang perlu diupdate, tambahkan di sini
            ]);

            // Jika semua proses berhasil, commit transaction
            DB::commit();

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaction
            DB::rollBack();

            // Opsional: Log error untuk debugging
            Log::error('Gagal memperbarui mahasiswa: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()
                ->withInput() // Mengembalikan input sebelumnya agar form terisi kembali
                ->with('error', 'Terjadi kesalahan saat memperbarui data mahasiswa. Silakan coba lagi.');
        }
    }

    public function detail($id)
    {
        $mahasiswa = Mahasiswa::with('users', 'jurusans')->findOrFail($id);

        $data = [
            'title' => 'Detail Mahasiswa',
            'mahasiswa' => $mahasiswa,
        ];

        return view('admin.mahasiswa.detail', $data);
    }

    public function verifikasi()
    {
        $mahasiswa = Mahasiswa::with('users', 'jurusans')->whereHas('users', function ($query) {
            $query->where('status_akun', 'Tidak Aktif');
        })->get();

        $data = [
            'title' => 'Verifikasi Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'no' => 1,
        ];

        return view('admin.mahasiswa.verifikasi', $data);
    }

    public function status($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = $mahasiswa->users;

        if ($user) {
            // Cek apakah akun belum aktif untuk menghindari pengiriman email berulang jika sudah aktif
            if ($user->status_akun !== 'Aktif') {
                $user->status_akun = 'Aktif'; // Set status menjadi Aktif
                $user->save();

                try {
                    // Kirim email notifikasi
                    Mail::to($user->email)->send(new AccountVerifiedMail($user));

                    // Pesan sukses bisa mencakup info pengiriman email (opsional)
                    // return redirect()->back()->with('success', 'Akun ' . $user->name . ' telah berhasil diverifikasi dan notifikasi email telah dikirim.');
                } catch (\Exception $e) {
                    // Jika pengiriman email gagal, log errornya tapi proses verifikasi tetap dianggap berhasil
                    Log::error('Gagal mengirim email verifikasi akun untuk user ID ' . $user->id . ': ' . $e->getMessage());
                    // Anda bisa menambahkan pesan berbeda jika email gagal terkirim
                    return redirect()->back()->with('success_with_email_warning', 'Akun ' . $user->name . ' telah diverifikasi, namun email notifikasi gagal dikirim.');
                }

                return redirect()->back()->with('success', 'Akun ' . $user->name . ' telah berhasil diverifikasi.');
            } else {
                // Jika akun sudah aktif sebelumnya
                return redirect()->back()->with('info', 'Akun ' . $user->name . ' sudah aktif sebelumnya.');
            }
        }
        return redirect()->back()->with('error', 'Gagal memverifikasi akun. Pengguna tidak ditemukan.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Memulai database transaction
        DB::beginTransaction();

        try {
            // Hapus data mahasiswa
            $mahasiswa->delete();

            // Hapus data user terkait
            User::where('id', $mahasiswa->user_id)->delete();

            // Jika semua proses berhasil, commit transaction
            DB::commit();

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaction
            DB::rollBack();

            // Opsional: Log error untuk debugging
            Log::error('Gagal menghapus mahasiswa: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data mahasiswa. Silakan coba lagi.');
        }
    }
}
