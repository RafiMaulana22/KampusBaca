<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $guarded = ['id'];

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
