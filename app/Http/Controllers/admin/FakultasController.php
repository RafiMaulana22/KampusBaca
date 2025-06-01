<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Ensure you import Str for slug generation

class FakultasController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Fakultas',
            'fakultas' => Fakultas::all(),
            'no' => 1,
        ];

        return view('admin.fakultas.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255|unique:fakultas,nama_fakultas',
        ], [
            'nama_fakultas.required' => 'Nama fakultas tidak boleh kosong, ya. Mohon diisi.',
            'nama_fakultas.string'   => 'Format nama fakultas sepertinya keliru, seharusnya berupa teks.',
            'nama_fakultas.max'      => 'Nama fakultas terlalu panjang. Maksimal hanya 255 karakter saja.',
            'nama_fakultas.unique'   => 'Nama fakultas ini sudah terdaftar. Coba gunakan nama lain, ya.'
        ]);

        Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
            'slug' => Str::slug($request->nama_fakultas),
        ]);

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function update(Request $request, $fakultas)
    {
        $fakultas = Fakultas::where('slug', $fakultas)->firstOrFail();

        $request->validate([
            'nama_fakultas' => 'required|string|max:255|unique:fakultas,nama_fakultas,' . $fakultas->id,
        ], [
            'nama_fakultas.required' => 'Nama fakultas tidak boleh kosong, ya. Mohon diisi.',
            'nama_fakultas.string'   => 'Format nama fakultas sepertinya keliru, seharusnya berupa teks.',
            'nama_fakultas.max'      => 'Nama fakultas terlalu panjang. Maksimal hanya 255 karakter saja.',
            'nama_fakultas.unique'   => 'Nama fakultas ini sudah terdaftar. Coba gunakan nama lain, ya.'
        ]);

        $fakultas->update([
            'nama_fakultas' => $request->nama_fakultas,
            'slug' => Str::slug($request->nama_fakultas),
        ]);

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy($fakultas)
    {
        $fakultas = Fakultas::where('slug', $fakultas)->firstOrFail();
        $fakultas->delete();

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil dihapus.');
    }
}
