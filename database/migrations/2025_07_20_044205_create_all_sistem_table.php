<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'guru', 'karyawan', 'siswa']);
            $table->timestamps();
        });

        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurusan');
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('guru_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('instrumen', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan');
            $table->enum('target', ['guru', 'karyawan']);
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('target_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instrumen_id')->constrained('instrumen')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade');
            $table->integer('skor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('guru');
        Schema::dropIfExists('karyawan');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('jurusan');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('guru_kelas');
        Schema::dropIfExists('instrumen');
        Schema::dropIfExists('periode');
        Schema::dropIfExists('penilaian');
    }
};
