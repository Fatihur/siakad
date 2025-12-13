<?php

namespace Database\Seeders;

use App\Models\{User, TahunAkademik, Semester, Jurusan, Kelas, Ruang, MataPelajaran, Guru, Siswa, Jadwal, Notifikasi};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@siakad.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Tahun Akademik & Semester
        $tahun = TahunAkademik::create(['tahun' => '2024/2025', 'aktif' => true]);
        Semester::create(['tahun_akademik_id' => $tahun->id, 'tipe' => 'ganjil', 'aktif' => true]);
        Semester::create(['tahun_akademik_id' => $tahun->id, 'tipe' => 'genap']);

        // Jurusan
        $ipa = Jurusan::create(['kode' => 'IPA', 'nama' => 'Ilmu Pengetahuan Alam']);
        $ips = Jurusan::create(['kode' => 'IPS', 'nama' => 'Ilmu Pengetahuan Sosial']);

        // Kelas
        $kelasXIPA1 = Kelas::create(['nama' => 'X IPA 1', 'tingkat' => 'X', 'jurusan_id' => $ipa->id, 'rombel' => '1']);
        $kelasXIPS1 = Kelas::create(['nama' => 'X IPS 1', 'tingkat' => 'X', 'jurusan_id' => $ips->id, 'rombel' => '1']);

        // Ruang
        $ruang1 = Ruang::create(['kode' => 'R101', 'nama' => 'Ruang 101', 'tipe' => 'teori']);
        $ruang2 = Ruang::create(['kode' => 'R102', 'nama' => 'Ruang 102', 'tipe' => 'teori']);
        $lab = Ruang::create(['kode' => 'LAB1', 'nama' => 'Lab Komputer', 'tipe' => 'lab']);

        // Mata Pelajaran
        $mtk = MataPelajaran::create(['kode' => 'MTK', 'nama' => 'Matematika', 'kelompok' => 'wajib', 'jam_per_minggu' => 4]);
        $bind = MataPelajaran::create(['kode' => 'BIND', 'nama' => 'Bahasa Indonesia', 'kelompok' => 'wajib', 'jam_per_minggu' => 4]);
        $bing = MataPelajaran::create(['kode' => 'BING', 'nama' => 'Bahasa Inggris', 'kelompok' => 'wajib', 'jam_per_minggu' => 2]);
        $fis = MataPelajaran::create(['kode' => 'FIS', 'nama' => 'Fisika', 'kelompok' => 'peminatan', 'jam_per_minggu' => 3]);

        // Guru
        $userGuru1 = User::create(['name' => 'Budi Santoso', 'email' => 'budi@siakad.com', 'username' => '198501012010011001', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guru1 = Guru::create(['user_id' => $userGuru1->id, 'nip' => '198501012010011001', 'nama' => 'Budi Santoso', 'jenis_kelamin' => 'L']);

        $userGuru2 = User::create(['name' => 'Siti Rahayu', 'email' => 'siti@siakad.com', 'username' => '198702152011012002', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guru2 = Guru::create(['user_id' => $userGuru2->id, 'nip' => '198702152011012002', 'nama' => 'Siti Rahayu', 'jenis_kelamin' => 'P']);

        // Siswa
        $userSiswa1 = User::create(['name' => 'Ahmad Fauzi', 'email' => 'ahmad@siakad.com', 'username' => '2024001', 'password' => Hash::make('password'), 'role' => 'siswa']);
        Siswa::create(['user_id' => $userSiswa1->id, 'nis' => '2024001', 'nama' => 'Ahmad Fauzi', 'jenis_kelamin' => 'L', 'kelas_id' => $kelasXIPA1->id]);

        $userSiswa2 = User::create(['name' => 'Dewi Lestari', 'email' => 'dewi@siakad.com', 'username' => '2024002', 'password' => Hash::make('password'), 'role' => 'siswa']);
        Siswa::create(['user_id' => $userSiswa2->id, 'nis' => '2024002', 'nama' => 'Dewi Lestari', 'jenis_kelamin' => 'P', 'kelas_id' => $kelasXIPA1->id]);

        $userSiswa3 = User::create(['name' => 'Rizki Pratama', 'email' => 'rizki@siakad.com', 'username' => '2024003', 'password' => Hash::make('password'), 'role' => 'siswa']);
        Siswa::create(['user_id' => $userSiswa3->id, 'nis' => '2024003', 'nama' => 'Rizki Pratama', 'jenis_kelamin' => 'L', 'kelas_id' => $kelasXIPA1->id]);

        // Jadwal
        $semester = Semester::where('aktif', true)->first();
        Jadwal::create(['semester_id' => $semester->id, 'kelas_id' => $kelasXIPA1->id, 'mata_pelajaran_id' => $mtk->id, 'guru_id' => $guru1->id, 'ruang_id' => $ruang1->id, 'hari' => 'senin', 'jam_mulai' => '07:00', 'jam_selesai' => '08:30', 'dipublikasi' => true]);
        Jadwal::create(['semester_id' => $semester->id, 'kelas_id' => $kelasXIPA1->id, 'mata_pelajaran_id' => $bind->id, 'guru_id' => $guru2->id, 'ruang_id' => $ruang1->id, 'hari' => 'senin', 'jam_mulai' => '08:30', 'jam_selesai' => '10:00', 'dipublikasi' => true]);
        Jadwal::create(['semester_id' => $semester->id, 'kelas_id' => $kelasXIPA1->id, 'mata_pelajaran_id' => $fis->id, 'guru_id' => $guru1->id, 'ruang_id' => $lab->id, 'hari' => 'selasa', 'jam_mulai' => '07:00', 'jam_selesai' => '08:30', 'dipublikasi' => true]);
        Jadwal::create(['semester_id' => $semester->id, 'kelas_id' => $kelasXIPA1->id, 'mata_pelajaran_id' => $bing->id, 'guru_id' => $guru2->id, 'ruang_id' => $ruang1->id, 'hari' => 'rabu', 'jam_mulai' => '07:00', 'jam_selesai' => '08:30', 'dipublikasi' => true]);

        // Sample Notifikasi
        Notifikasi::create(['user_id' => $userSiswa1->id, 'judul' => 'Selamat Datang!', 'pesan' => 'Selamat datang di SIAKAD. Silakan lengkapi profil Anda.', 'tipe' => 'info']);
        Notifikasi::create(['user_id' => $userSiswa1->id, 'judul' => 'Jadwal Baru', 'pesan' => 'Jadwal pelajaran semester ganjil telah dipublikasikan.', 'tipe' => 'success']);
        Notifikasi::create(['user_id' => $userSiswa1->id, 'judul' => 'Tugas Baru: Matematika', 'pesan' => 'Tugas baru dari Budi Santoso. Deadline: 20/12/2024', 'tipe' => 'warning']);
        Notifikasi::create(['user_id' => $userGuru1->id, 'judul' => 'Selamat Datang!', 'pesan' => 'Selamat datang di SIAKAD. Silakan lengkapi jadwal mengajar Anda.', 'tipe' => 'info']);
        Notifikasi::create(['user_id' => $userGuru1->id, 'judul' => 'Pengajuan Nilai', 'pesan' => 'Silakan ajukan nilai siswa untuk verifikasi admin.', 'tipe' => 'info']);
    }
}
