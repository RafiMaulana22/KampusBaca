<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jurusans()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
