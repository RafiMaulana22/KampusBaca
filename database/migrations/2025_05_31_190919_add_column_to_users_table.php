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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_telepon', 20)->nullable()->after('email');
            $table->enum('status_akun', ['Aktif', 'Tidak Aktif'])->default('Aktif')->after('password');
            $table->timestamp('tanggal_registrasi_akun')->useCurrent()->after('email_verified_at');
            $table->timestamp('tanggal_terakhir_login')->nullable()->after('tanggal_registrasi_akun');
            $table->string('reset_password_token')->nullable()->after('tanggal_terakhir_login');
            $table->timestamp('reset_password_token_expired_at')->nullable()->after('reset_password_token');
            $table->timestamp('tanggal_verifikasi_akun')->nullable()->after('status_akun');
            $table->string('dummy_password')->nullable()->after('tanggal_verifikasi_akun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
