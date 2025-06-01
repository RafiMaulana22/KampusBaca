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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            // Data Identitas Utama
            $table->string('nim', 20);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('foto_mahasiswa')->nullable();

            // Data Akademik
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('restrict');
            $table->string('angkatan');
            $table->enum('status_mahasiswa', ['Aktif', 'Cuti', 'Lulus', 'Drop Out'])->default('Aktif');

            // Data Terkait Kuota Peminjaman
            $table->integer('kuota_maksimal_peminjaman')->default(5);

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
