<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = [
            'title'       => 'Peminjaman',
            'peminjamans' => Peminjaman::with('bukus', 'mahasiswas')->get(),
            'no'          => 1,
        ];

        return view('admin.peminjaman.index', $data);
    }
}
