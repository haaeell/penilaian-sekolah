<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Karyawan;
use App\Models\Siswa;
use App\Models\Instrumen;
use App\Models\Periode;
use App\Models\Penilaian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jurusan
        $tkj = Jurusan::create(['nama_jurusan' => 'TKJ']);
        $rpl = Jurusan::create(['nama_jurusan' => 'RPL']);

        // Kelas
        $tkjKelas1 = Kelas::create(['nama_kelas' => 'X TKJ 1', 'jurusan_id' => $tkj->id]);
        $tkjKelas2 = Kelas::create(['nama_kelas' => 'XI TKJ 1', 'jurusan_id' => $tkj->id]);
        $rplKelas1 = Kelas::create(['nama_kelas' => 'X RPL 1', 'jurusan_id' => $rpl->id]);
        $rplKelas2 = Kelas::create(['nama_kelas' => 'XI RPL 1', 'jurusan_id' => $rpl->id]);

        // Users
        $adminUser = User::create(['email' => 'admin@school.com', 'password' => Hash::make('password'), 'role' => 'admin']);
        $guruTkjUser = User::create(['email' => 'guru1@school.com', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guruRplUser = User::create(['email' => 'guru2@school.com', 'password' => Hash::make('password'), 'role' => 'guru']);
        $karyawanTkjUser = User::create(['email' => 'karyawan1@school.com', 'password' => Hash::make('password'), 'role' => 'karyawan']);
        $karyawanRplUser = User::create(['email' => 'karyawan2@school.com', 'password' => Hash::make('password'), 'role' => 'karyawan']);
        $siswaTkjUser = User::create(['email' => 'siswa1@school.com', 'password' => Hash::make('password'), 'role' => 'siswa']);
        $siswaRplUser = User::create(['email' => 'siswa2@school.com', 'password' => Hash::make('password'), 'role' => 'siswa']);

        // Admin
        Admin::create(['user_id' => $adminUser->id, 'nama' => 'Admin Utama']);

        // Guru
        $guruTkj = Guru::create(['user_id' => $guruTkjUser->id, 'nama' => 'Guru TKJ']);
        $guruRpl = Guru::create(['user_id' => $guruRplUser->id, 'nama' => 'Guru RPL']);

        // Karyawan
        $karyawanTkj = Karyawan::create(['user_id' => $karyawanTkjUser->id, 'nama' => 'Karyawan Lab TKJ', 'jurusan_id' => $tkj->id]);
        $karyawanRpl = Karyawan::create(['user_id' => $karyawanRplUser->id, 'nama' => 'Karyawan Lab RPL', 'jurusan_id' => $rpl->id]);

        // Siswa
        $siswaTkj = Siswa::create(['user_id' => $siswaTkjUser->id, 'nama' => 'Siswa TKJ 1', 'kelas_id' => $tkjKelas1->id, 'jurusan_id' => $tkj->id]);
        $siswaRpl = Siswa::create(['user_id' => $siswaRplUser->id, 'nama' => 'Siswa RPL 1', 'kelas_id' => $rplKelas1->id, 'jurusan_id' => $rpl->id]);

        // GuruKelas
        DB::table('guru_kelas')->insert([
            ['guru_id' => $guruTkj->id, 'kelas_id' => $tkjKelas1->id, 'created_at' => now(), 'updated_at' => now()],
            ['guru_id' => $guruRpl->id, 'kelas_id' => $rplKelas1->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Instrumen
        $instrumenGuru1 = Instrumen::create(['pertanyaan' => 'Seberapa efektif guru dalam menyampaikan materi?', 'target' => 'guru']);
        $instrumenGuru2 = Instrumen::create(['pertanyaan' => 'Seberapa responsif guru terhadap pertanyaan siswa?', 'target' => 'guru']);
        $instrumenKaryawanTkj = Instrumen::create(['pertanyaan' => 'Seberapa baik karyawan menjaga fasilitas lab TKJ?', 'target' => 'karyawan', 'jurusan_id' => $tkj->id]);
        $instrumenKaryawanRpl = Instrumen::create(['pertanyaan' => 'Seberapa baik karyawan menjaga fasilitas lab RPL?', 'target' => 'karyawan', 'jurusan_id' => $rpl->id]);

        // Periode
        $periode = Periode::create([
            'nama_periode' => 'Penilaian Semester 1 2025',
            'waktu_mulai' => Carbon::create(2025, 7, 1),
            'waktu_selesai' => Carbon::create(2025, 7, 31),
            'is_active' => true,
        ]);
        Periode::create([
            'nama_periode' => 'Penilaian Semester 2 2024',
            'waktu_mulai' => Carbon::create(2024, 12, 1),
            'waktu_selesai' => Carbon::create(2024, 12, 31),
            'is_active' => false,
        ]);

        // ======================
        // Penilaian (Pakainya Snapshot)
        // ======================
        $this->buatPenilaian($siswaTkj, $guruTkjUser, $instrumenGuru1, $periode, 4);
        $this->buatPenilaian($siswaTkj, $guruTkjUser, $instrumenGuru2, $periode, 5);
        $this->buatPenilaian($siswaTkj, $karyawanTkjUser, $instrumenKaryawanTkj, $periode, 3);
        $this->buatPenilaian($siswaRpl, $guruRplUser, $instrumenGuru1, $periode, 5);
        $this->buatPenilaian($siswaRpl, $guruRplUser, $instrumenGuru2, $periode, 4);
        $this->buatPenilaian($siswaRpl, $karyawanRplUser, $instrumenKaryawanRpl, $periode, 4);
    }

    private function buatPenilaian($siswa, $targetUser, $instrumen, $periode, $skor)
    {
        $namaTarget = $targetUser->guru->nama ?? $targetUser->karyawan->nama ?? $targetUser->email;

        Penilaian::create([
            'nama_siswa' => $siswa->nama,
            'nama_target' => $namaTarget,
            'nama_instrumen' => $instrumen->pertanyaan,
            'nama_periode' => $periode->nama_periode,

            'siswa_id' => $siswa->id,
            'target_id' => $targetUser->id,
            'instrumen_id' => $instrumen->id,
            'periode_id' => $periode->id,

            'skor' => $skor,
        ]);
    }
}
