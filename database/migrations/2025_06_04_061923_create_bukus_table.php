<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->year('tahun_terbit')->nullable();
            $table->string('bahasa', 50)->nullable();
            $table->string('gambar_sampul')->nullable();

            // Info File Digital
            $table->string('file_buku')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Administratif
            $table->enum('status_ketersediaan', ['Tersedia', 'Dalam Peminjaman'])->default('Tersedia');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
