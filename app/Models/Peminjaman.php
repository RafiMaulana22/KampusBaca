<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';
    protected $guarded = ['id'];

    public function bukus()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function mahasiswas()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
