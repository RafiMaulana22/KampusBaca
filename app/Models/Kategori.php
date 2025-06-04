<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $guarded = [];

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'buku_kategoris', 'kategori_id', 'buku_id');
    }
}
