<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Staff',
            'staff' => Staff::with('users')->get(),
            'no'   => 1, // Untuk nomor urut pada tabel
        ];

        return view('admin.staff.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Staff',
        ];

        return view('admin.staff.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',                  // Nama Lengkap Staff
            'nip'      => 'required|string|unique:staff,nip|max:50',  // NIP, unik di tabel 'staff' kolom 'nip'
            'email'    => 'required|email|unique:users,email',        // Email, unik di tabel 'users' kolom 'email'
            'password' => 'required|string|min:8',                    // Password, minimal 8 karakter
            // Tambahkan validasi lain jika ada field tambahan untuk staff, misalnya 'role_id', 'jabatan', dll.
        ], [
            // Pesan kustom untuk validasi (opsional, bisa disesuaikan)
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string'   => 'Nama lengkap harus berupa teks.',
            'name.max'      => 'Nama lengkap tidak boleh lebih dari :max karakter.',

            'nip.required' => 'NIP wajib diisi.',
            'nip.string'   => 'NIP harus berupa teks atau angka.',
            'nip.unique'   => 'NIP ini sudah terdaftar. Silakan gunakan NIP lain.',
            'nip.max'      => 'NIP tidak boleh lebih dari :max karakter.',
            // Jika NIP memiliki format/panjang tertentu, Anda bisa menambahkan aturan seperti 'digits:18'

            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format alamat email tidak valid.',
            'email.unique'   => 'Alamat email ini sudah terdaftar. Silakan gunakan email lain.',

            'password.required' => 'Password wajib diisi.',
            'password.string'   => 'Password harus berupa teks.',
            'password.min'      => 'Password minimal harus :min karakter.',
            // Pertimbangkan menambahkan aturan 'confirmed' jika Anda memiliki field konfirmasi password:
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        // Memulai database transaction
        DB::beginTransaction();

        try {
            // 2. Buat dan simpan data ke tabel 'users'
            $user = User::create([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => bcrypt($request['password']), // Enkripsi password!
                'role'     => 'staff', // Misalnya, jika ada kolom role di tabel users
                'dummy_password' => $request['password'], // Simpan password asli jika diperlukan
                // Jika ada field lain di tabel users yang perlu diisi, tambahkan di sini
                // contoh: 'role' => 'mahasiswa', (jika ada kolom role)
            ]);

            // 3. Buat dan simpan data ke tabel 'staff' dengan user_id dari user yang baru dibuat
            Staff::create([
                'user_id'    => $user->id, // Ambil ID dari user yang baru dibuat
                'nip'        => $request['nip'],
                // Jika ada field lain di tabel staff yang perlu diisi, tambahkan di sini
            ]);

            // Jika semua proses berhasil, commit transaction
            DB::commit();

            return redirect()->route('staff.index')->with('success', 'Staff berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaction
            DB::rollBack();

            // Opsional: Log error untuk debugging
            Log::error('Gagal menambahkan staff: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()
                ->withInput() // Mengembalikan input sebelumnya agar form terisi kembali
                ->with('error', 'Terjadi kesalahan saat menambahkan data staff. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Staff',
            'staff' => Staff::with('users')->findOrFail($id),
        ];

        return view('admin.staff.update', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',                  // Nama Lengkap Staff
            'nip'      => 'required|string|max:50|unique:staff,nip,' . $id, // NIP, unik di tabel 'staff' kolom 'nip' kecuali untuk staff yang sedang diedit
            'email'    => 'required|email|unique:users,email,' . $id, // Email, unik di tabel 'users' kolom 'email' kecuali untuk user yang sedang diedit
            'password' => 'nullable|string|min:8',                    // Password, minimal 8 karakter (opsional, jika ingin mengubah password)
            // Tambahkan validasi lain jika ada field tambahan untuk staff, misalnya 'role_id', 'jabatan', dll.
        ], [
            // Pesan kustom untuk validasi (opsional, bisa disesuaikan)
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string'   => 'Nama lengkap harus berupa teks.',
            'name.max'      => 'Nama lengkap tidak boleh lebih dari :max karakter.',

            'nip.required' => 'NIP wajib diisi.',
            'nip.string'   => 'NIP harus berupa teks atau angka.',
            'nip.unique'   => 'NIP ini sudah terdaftar. Silakan gunakan NIP lain.',
            'nip.max'      => 'NIP tidak boleh lebih dari :max karakter.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format alamat email tidak valid.',
            'email.unique'   => 'Alamat email ini sudah terdaftar. Silakan gunakan email lain.',

            'password.string' => 'Password harus berupa teks.',
            'password.min'    => 'Password minimal harus :min karakter.',
            // Pertimbangkan menambahkan aturan 'confirmed' jika Anda memiliki field konfirmasi password:
            // 'password' => 'nullable|string|min:8|confirmed',
            'password.nullable' => 'Jika tidak ingin mengubah password, biarkan kosong.',
        ]);

        // Memulai database transaction
        DB::beginTransaction();

        try {
            // 2. Update data pada tabel users
            $user = User::findOrFail($id);
            $user->update([
                'name'  => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']) ?: $user->password, // Enkripsi password jika diisi, jika tidak, tetap gunakan password lama
                'dummy_password' => $request['password'] ?: $user->dummy_password, // Simpan password asli jika diperlukan
                // Jika ada field lain di tabel users yang perlu diupdate, tambahkan di sini
                // contoh: 'role' => $request['role'], (jika ada kolom role)
            ]);

            // 3. Update data pada tabel staff
            $staff = Staff::findOrFail($id);
            $staff->update([
                'nip' => $request['nip'],
                // Jika ada field lain di tabel staff yang perlu diupdate, tambahkan di sini
            ]);
            // Jika semua proses berhasil, commit transaction
            DB::commit();
            return redirect()->route('staff.index')->with('success', 'Staff berhasil diperbarui.');
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaction
            DB::rollBack();

            // Opsional: Log error untuk debugging
            Log::error('Gagal memperbarui staff: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()
                ->withInput() // Mengembalikan input sebelumnya agar form terisi kembali
                ->with('error', 'Terjadi kesalahan saat memperbarui data staff. Silakan coba lagi.');
        }
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Detail Staff',
            'staff' => Staff::with('users')->findOrFail($id),
        ];

        return view('admin.staff.detail', $data);
    }

    public function destroy($id)
    {
        // Memulai database transaction
        DB::beginTransaction();

        try {
            // Hapus data staff berdasarkan ID
            $staff = Staff::findOrFail($id);
            $user = User::findOrFail($staff->user_id);

            // Hapus data staff dan user terkait
            $staff->delete();
            $user->delete();

            // Jika semua proses berhasil, commit transaction
            DB::commit();

            return redirect()->route('staff.index')->with('success', 'Staff berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaction
            DB::rollBack();

            // Opsional: Log error untuk debugging
            Log::error('Gagal menghapus staff: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data staff. Silakan coba lagi.');
        }
    }
}
