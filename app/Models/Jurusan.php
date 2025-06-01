<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusans';
    protected $guarded = [];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
}
