<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Buku',
            'buku'  => Buku::with('kategoris')->get(),
            'no'    => 1
        ];

        return view('admin.buku.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Buku',
            'kategoris' => Kategori::get(),
        ];

        return view('admin.buku.create', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'judul_buku'    => 'required|string|max:255|unique:bukus,judul',
            'tahun_terbit'  => 'required|integer|digits:4|min:1500|max:' . date('Y'),
            'bahasa'        => 'required|string|max:50',
            'kategori_id'    => 'required',
            'gambar_sampul' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Maks 2MB
            'file_buku'     => 'required|file|mimes:pdf,epub,mobi|max:10240', // Maks 10MB
            // Tambahkan validasi lain jika ada
        ], [
            // Validasi untuk Judul Buku
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'judul_buku.string'   => 'Judul buku harus berupa teks.',
            'judul_buku.max'      => 'Judul buku tidak boleh lebih dari :max karakter.',
            'judul_buku.unique'   => 'Judul buku ini sudah ada dalam sistem.',

            // Validasi untuk Tahun Terbit
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.digits'   => 'Tahun terbit harus terdiri dari :digits digit angka (contoh: 2023).',
            'tahun_terbit.min'      => 'Tahun terbit minimal adalah :min.',
            'tahun_terbit.max'      => 'Tahun terbit tidak boleh melebihi tahun sekarang (:max).',

            // Validasi untuk Bahasa
            'bahasa.required' => 'Bahasa buku wajib diisi.',
            'bahasa.string'   => 'Bahasa buku harus berupa teks.',
            'bahasa.max'      => 'Bahasa buku tidak boleh lebih dari :max karakter.',

            // Validasi untuk Kategori
            'kategori_id.required' => 'Minimal satu kategori wajib dipilih.',

            // Validasi untuk Gambar Sampul
            'gambar_sampul.image' => 'File yang diunggah harus berupa gambar.',
            'gambar_sampul.mimes' => 'Format gambar sampul harus :values (jpg, jpeg, png, webp).',
            'gambar_sampul.max'   => 'Ukuran gambar sampul tidak boleh lebih dari :max kilobyte (KB).', // Laravel :max untuk file adalah dalam KB

            // Validasi untuk File Buku
            'file_buku.required' => 'File buku wajib diunggah.',
            'file_buku.file'     => 'Unggahan untuk file buku harus berupa file.',
            'file_buku.mimes'    => 'Format file buku harus :values (pdf, epub, mobi).',
            'file_buku.max'      => 'Ukuran file buku tidak boleh lebih dari :max kilobyte (KB).',
        ]);

        $pathGambarSampul = null;
        $uploadedGambarSampulPath = null; // Untuk rollback jika error

        if ($request->hasFile('gambar_sampul') && $request->file('gambar_sampul')->isValid()) {
            $file = $request->file('gambar_sampul');
            $extension = $file->getClientOriginalExtension();
            // Membuat nama file unik untuk menghindari konflik
            $filename = 'sampul_' . time() . '_' . Str::random(10) . '.' . $extension;
            $destinationPath = public_path('sampul-buku'); // Path ke public/sampul-buku

            // Pastikan direktori ada, jika tidak buat
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0775, true, true); // 0775 agar writable
            }

            try {
                $file->move($destinationPath, $filename);
                $pathGambarSampul = 'sampul-buku/' . $filename; // Path relatif dari folder public
                $uploadedGambarSampulPath = public_path($pathGambarSampul); // Path absolut untuk rollback
            } catch (\Exception $e) {
                Log::error("Gagal memindahkan file gambar sampul: " . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal mengunggah gambar sampul.')->withInput();
            }
        }

        // Penanganan File Buku (tetap bisa menggunakan Storage jika Anda mau, atau cara yang sama dengan gambar sampul)
        // Untuk konsistensi, jika file buku juga mau di public path tertentu, gunakan cara serupa.
        // Jika tetap di storage/app/public:
        $pathFileBuku = null;
        $uploadedFileBukuPathForStorage = null; // Untuk rollback jika file_buku disimpan di storage
        $uploadedFileBukuPathPublic = null; // Untuk rollback jika file_buku disimpan di public

        if ($request->hasFile('file_buku') && $request->file('file_buku')->isValid()) {
            // Contoh jika file buku juga ingin di public/file-buku
            $fileBuku = $request->file('file_buku');
            $extensionBuku = $fileBuku->getClientOriginalExtension();
            $filenameBuku = 'buku_' . time() . '_' . Str::random(10) . '.' . $extensionBuku;
            $destinationPathBuku = public_path('file-buku');

            if (!File::isDirectory($destinationPathBuku)) {
                File::makeDirectory($destinationPathBuku, 0775, true, true);
            }
            try {
                $fileBuku->move($destinationPathBuku, $filenameBuku);
                $pathFileBuku = 'file-buku/' . $filenameBuku;
                $uploadedFileBukuPathPublic = public_path($pathFileBuku);
            } catch (\Exception $e) {
                // Hapus gambar sampul jika sudah terupload sebelum error file buku
                if ($uploadedGambarSampulPath && File::exists($uploadedGambarSampulPath)) {
                    File::delete($uploadedGambarSampulPath);
                }
                Log::error("Gagal memindahkan file buku: " . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal mengunggah file buku.')->withInput();
            }
        }


        DB::beginTransaction();
        try {
            $buku = Buku::create([
                'judul'               => $validatedData['judul_buku'],
                'tahun_terbit'        => $validatedData['tahun_terbit'],
                'bahasa'              => $validatedData['bahasa'],
                'gambar_sampul'       => $pathGambarSampul, // Simpan path relatif dari public
                'file_buku'           => $pathFileBuku,     // Simpan path relatif dari public (jika diubah)
                'status_ketersediaan' => 'Tersedia',
                'user_id'             => Auth::user()->id,
                'kategori_id'         => $validatedData['kategori_id'],
            ]);

            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file yang sudah terupload jika terjadi error saat menyimpan ke DB
            if ($uploadedGambarSampulPath && File::exists($uploadedGambarSampulPath)) {
                File::delete($uploadedGambarSampulPath);
            }
            if ($uploadedFileBukuPathPublic && File::exists($uploadedFileBukuPathPublic)) {
                File::delete($uploadedFileBukuPathPublic);
            }
            // Jika file_buku disimpan di storage:
            // if ($uploadedFileBukuPathForStorage && Storage::disk('public')->exists($uploadedFileBukuPathForStorage)) {
            //     Storage::disk('public')->delete($uploadedFileBukuPathForStorage);
            // }

            Log::error("Gagal menyimpan buku ke database: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan buku ke database. Silakan coba lagi.')->withInput();
        }
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Edit Buku',
            'buku'      => Buku::findOrFail($id),
            'kategoris' => Kategori::all(),
        ];

        return view('admin.buku.edit', $data);
    }

    public function update(Request $request, Buku $buku)
    {
        $validatedData = $request->validate([
            'judul_buku' => [
                'required',
                'string',
                'max:255',
            ],
            'tahun_terbit' => 'required|integer|digits:4|min:1500|max:' . date('Y'),
            'bahasa'       => 'required|string|max:50',
            'kategori_ids' => 'required|array', // Diubah dari kategori_id
            'kategori_ids.*' => 'exists:kategori_buku,id', // Validasi setiap item dalam array, pastikan nama tabel 'kategori_buku' benar
            'gambar_sampul' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Maks 2MB
            'file_buku'     => 'nullable|file|mimes:pdf,epub,mobi|max:10240', // Maks 10MB, diubah jadi nullable
            // Tambahkan validasi lain jika ada (mis. ISBN, Penerbit, Penulis jika sudah ditambahkan ke form)
        ], [
            // Validasi untuk Judul Buku
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'judul_buku.string'   => 'Judul buku harus berupa teks.',
            'judul_buku.max'      => 'Judul buku tidak boleh lebih dari :max karakter.',
            'judul_buku.unique'   => 'Judul buku ini sudah ada dalam sistem.',

            // Validasi untuk Tahun Terbit
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.digits'   => 'Tahun terbit harus terdiri dari :digits digit angka (contoh: 2023).',
            'tahun_terbit.min'      => 'Tahun terbit minimal adalah :min.',
            'tahun_terbit.max'      => 'Tahun terbit tidak boleh melebihi tahun sekarang (:max).',

            // Validasi untuk Bahasa
            'bahasa.required' => 'Bahasa buku wajib diisi.',
            'bahasa.string'   => 'Bahasa buku harus berupa teks.',
            'bahasa.max'      => 'Bahasa buku tidak boleh lebih dari :max karakter.',

            // Validasi untuk Kategori
            'kategori_id.required' => 'Minimal satu kategori wajib dipilih.', // Pesan untuk array

            // Validasi untuk Gambar Sampul
            'gambar_sampul.image' => 'File yang diunggah harus berupa gambar.',
            'gambar_sampul.mimes' => 'Format gambar sampul harus :values (jpg, jpeg, png, webp).',
            'gambar_sampul.max'   => 'Ukuran gambar sampul tidak boleh lebih dari :max kilobyte (KB).',

            // Validasi untuk File Buku
            // 'file_buku.required' => 'File buku wajib diunggah.', // Tidak lagi required
            'file_buku.file'    => 'Unggahan untuk file buku harus berupa file.',
            'file_buku.mimes'   => 'Format file buku harus :values (pdf, epub, mobi).',
            'file_buku.max'     => 'Ukuran file buku tidak boleh lebih dari :max kilobyte (KB).',
        ]);

        $pathGambarSampul = $buku->gambar_sampul; // Path lama sebagai default
        $uploadedGambarSampulPathForRollback = null; // Path absolut file baru untuk rollback
        $oldGambarSampulPath = $buku->gambar_sampul ? public_path($buku->gambar_sampul) : null;

        if ($request->hasFile('gambar_sampul') && $request->file('gambar_sampul')->isValid()) {
            $file = $request->file('gambar_sampul');
            $extension = $file->getClientOriginalExtension();
            $filename = 'sampul_' . time() . '_' . Str::random(10) . '.' . $extension;
            $destinationPath = public_path('sampul-buku');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0775, true, true);
            }

            try {
                $file->move($destinationPath, $filename);
                $pathGambarSampul = 'sampul-buku/' . $filename; // Path baru
                $uploadedGambarSampulPathForRollback = public_path($pathGambarSampul);
            } catch (\Exception $e) {
                Log::error("Gagal memindahkan file gambar sampul (update): " . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal mengunggah gambar sampul baru.')->withInput();
            }
        }

        $pathFileBuku = $buku->file_buku; // Path lama sebagai default
        $uploadedFileBukuPathPublicForRollback = null; // Path absolut file baru untuk rollback
        $oldFileBukuPath = $buku->file_buku ? public_path($buku->file_buku) : null;
        // $namaFileAsliBuku = $buku->nama_file_asli; // Jika Anda menyimpan nama file asli

        if ($request->hasFile('file_buku') && $request->file('file_buku')->isValid()) {
            $fileBuku = $request->file('file_buku');
            // $namaFileAsliBuku = $fileBuku->getClientOriginalName(); // Simpan nama file asli baru
            $extensionBuku = $fileBuku->getClientOriginalExtension();
            $filenameBuku = 'buku_' . time() . '_' . Str::random(10) . '.' . $extensionBuku;
            $destinationPathBuku = public_path('file-buku');

            if (!File::isDirectory($destinationPathBuku)) {
                File::makeDirectory($destinationPathBuku, 0775, true, true);
            }
            try {
                $fileBuku->move($destinationPathBuku, $filenameBuku);
                $pathFileBuku = 'file-buku/' . $filenameBuku; // Path baru
                $uploadedFileBukuPathPublicForRollback = public_path($pathFileBuku);
            } catch (\Exception $e) {
                // Hapus gambar sampul BARU jika sudah terupload sebelum error file buku
                if ($uploadedGambarSampulPathForRollback && File::exists($uploadedGambarSampulPathForRollback) && $pathGambarSampul !== $buku->gambar_sampul) {
                    File::delete($uploadedGambarSampulPathForRollback);
                }
                Log::error("Gagal memindahkan file buku (update): " . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal mengunggah file buku baru.')->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $updateData = [
                'judul'         => $validatedData['judul_buku'], // Pastikan nama kolom di DB adalah 'judul'
                'tahun_terbit'  => $validatedData['tahun_terbit'],
                'bahasa'        => $validatedData['bahasa'],
                // 'nama_file_asli' => $namaFileAsliBuku, // Jika Anda menyimpan nama file asli
                // 'status_ketersediaan' => 'Tersedia', // Mungkin perlu logika khusus
                // user_id (pembuat) biasanya tidak diubah. updated_by_user_id bisa ditambahkan jika perlu.
                'kategori_id'   => $validatedData['kategori_id'],
            ];

            // Hanya update path gambar jika ada file baru yang diunggah
            if ($uploadedGambarSampulPathForRollback) {
                $updateData['gambar_sampul'] = $pathGambarSampul;
            }

            // Hanya update path file buku jika ada file baru yang diunggah
            if ($uploadedFileBukuPathPublicForRollback) {
                $updateData['file_buku'] = $pathFileBuku; // Pastikan nama kolom di DB adalah 'file_buku' atau 'path_penyimpanan_file'
            }

            $buku->update($updateData);

            DB::commit();

            // Hapus file lama SETELAH database berhasil diupdate
            if ($uploadedGambarSampulPathForRollback && $oldGambarSampulPath && $oldGambarSampulPath !== public_path($pathGambarSampul)) {
                if (File::exists($oldGambarSampulPath)) {
                    File::delete($oldGambarSampulPath);
                }
            }
            if ($uploadedFileBukuPathPublicForRollback && $oldFileBukuPath && $oldFileBukuPath !== public_path($pathFileBuku)) {
                if (File::exists($oldFileBukuPath)) {
                    File::delete($oldFileBukuPath);
                }
            }

            return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file BARU yang sudah terupload jika terjadi error saat menyimpan ke DB
            if ($uploadedGambarSampulPathForRollback && File::exists($uploadedGambarSampulPathForRollback)) {
                File::delete($uploadedGambarSampulPathForRollback);
            }
            if ($uploadedFileBukuPathPublicForRollback && File::exists($uploadedFileBukuPathPublicForRollback)) {
                File::delete($uploadedFileBukuPathPublicForRollback);
            }

            Log::error("Gagal memperbarui buku ke database: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui buku. Silakan coba lagi.')->withInput();
        }
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Detail Buku',
            'buku'  => Buku::with('kategoris', 'users')->findOrFail($id),
        ];

        return view('admin.buku.detail', $data);
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        // 1. Otorisasi (jika Anda menggunakan Gate atau Policy)
        // Misalnya: $this->authorize('delete', $buku);

        // Simpan path file sebelum record dihapus (berguna jika tidak soft delete atau untuk referensi)
        // Path ini adalah path relatif dari folder public, sesuai cara penyimpanan di 'store' dan 'update'
        $gambarSampulPath = $buku->gambar_sampul;
        $fileBukuPath = $buku->file_buku; // atau $buku->path_penyimpanan_file, sesuaikan nama kolom

        DB::beginTransaction();
        try {
            // 2. Hapus record buku dari database (akan melakukan soft delete jika model menggunakan SoftDeletes)
            $buku->delete();

            DB::commit();

            // 3. Jika penghapusan dari DB berhasil, hapus file fisik
            // Penghapusan file dilakukan setelah commit DB untuk memastikan integritas data.
            // Jika file gagal dihapus, setidaknya data di DB sudah (soft) terhapus.

            // Hapus Gambar Sampul
            if ($gambarSampulPath) {
                $fullGambarSampulPath = public_path($gambarSampulPath);
                if (File::exists($fullGambarSampulPath)) {
                    try {
                        File::delete($fullGambarSampulPath);
                    } catch (\Exception $e) {
                        Log::error("Gagal menghapus file gambar sampul fisik: {$fullGambarSampulPath}. Error: " . $e->getMessage());
                        // Anda bisa memutuskan apakah ingin memberitahu user atau hanya log error ini
                        // return redirect()->route('buku.index')->with('warning', 'Buku berhasil dihapus dari database, tetapi gagal menghapus file gambar sampul fisik.');
                    }
                } else {
                    Log::warning("File gambar sampul fisik tidak ditemukan untuk dihapus: {$fullGambarSampulPath}");
                }
            }

            // Hapus File Buku
            if ($fileBukuPath) {
                $fullFileBukuPath = public_path($fileBukuPath);
                if (File::exists($fullFileBukuPath)) {
                    try {
                        File::delete($fullFileBukuPath);
                    } catch (\Exception $e) {
                        Log::error("Gagal menghapus file buku fisik: {$fullFileBukuPath}. Error: " . $e->getMessage());
                        // return redirect()->route('buku.index')->with('warning', 'Buku berhasil dihapus dari database, tetapi gagal menghapus file buku fisik.');
                    }
                } else {
                    Log::warning("File buku fisik tidak ditemukan untuk dihapus: {$fullFileBukuPath}");
                }
            }

            return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal menghapus buku dari database: " . $e->getMessage());
            return redirect()->route('buku.index')->with('error', 'Gagal menghapus buku. Silakan coba lagi.');
        }
    }
}
