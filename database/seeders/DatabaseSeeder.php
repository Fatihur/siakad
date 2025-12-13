<?php

namespace Database\Seeders;

use App\Models\{User, TahunAkademik, Semester, Jurusan, Kelas, Ruang, MataPelajaran, Guru, Siswa, Jadwal, Notifikasi, JamIstirahat};
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
        $semesterGanjil = Semester::create(['tahun_akademik_id' => $tahun->id, 'tipe' => 'ganjil', 'aktif' => true]);
        Semester::create(['tahun_akademik_id' => $tahun->id, 'tipe' => 'genap']);

        // Jurusan SMK
        $tkj = Jurusan::create(['kode' => 'TKJ', 'nama' => 'Teknik Komputer dan Jaringan']);
        $rpl = Jurusan::create(['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak']);
        $mm = Jurusan::create(['kode' => 'MM', 'nama' => 'Multimedia']);
        $akl = Jurusan::create(['kode' => 'AKL', 'nama' => 'Akuntansi dan Keuangan Lembaga']);
        $otkp = Jurusan::create(['kode' => 'OTKP', 'nama' => 'Otomatisasi dan Tata Kelola Perkantoran']);

        // Kelas
        $kelasXTKJ1 = Kelas::create(['nama' => 'X TKJ 1', 'tingkat' => 'X', 'jurusan_id' => $tkj->id, 'rombel' => '1']);
        $kelasXTKJ2 = Kelas::create(['nama' => 'X TKJ 2', 'tingkat' => 'X', 'jurusan_id' => $tkj->id, 'rombel' => '2']);
        $kelasXRPL1 = Kelas::create(['nama' => 'X RPL 1', 'tingkat' => 'X', 'jurusan_id' => $rpl->id, 'rombel' => '1']);
        $kelasXMM1 = Kelas::create(['nama' => 'X MM 1', 'tingkat' => 'X', 'jurusan_id' => $mm->id, 'rombel' => '1']);
        $kelasXAKL1 = Kelas::create(['nama' => 'X AKL 1', 'tingkat' => 'X', 'jurusan_id' => $akl->id, 'rombel' => '1']);
        
        $kelasXITKJ1 = Kelas::create(['nama' => 'XI TKJ 1', 'tingkat' => 'XI', 'jurusan_id' => $tkj->id, 'rombel' => '1']);
        $kelasXIRPL1 = Kelas::create(['nama' => 'XI RPL 1', 'tingkat' => 'XI', 'jurusan_id' => $rpl->id, 'rombel' => '1']);
        
        $kelasXIITKJ1 = Kelas::create(['nama' => 'XII TKJ 1', 'tingkat' => 'XII', 'jurusan_id' => $tkj->id, 'rombel' => '1']);
        $kelasXIIRPL1 = Kelas::create(['nama' => 'XII RPL 1', 'tingkat' => 'XII', 'jurusan_id' => $rpl->id, 'rombel' => '1']);

        // Ruang
        $ruang1 = Ruang::create(['kode' => 'R01', 'nama' => 'Ruang Teori 1', 'tipe' => 'teori', 'kapasitas' => 36]);
        $ruang2 = Ruang::create(['kode' => 'R02', 'nama' => 'Ruang Teori 2', 'tipe' => 'teori', 'kapasitas' => 36]);
        $ruang3 = Ruang::create(['kode' => 'R03', 'nama' => 'Ruang Teori 3', 'tipe' => 'teori', 'kapasitas' => 36]);
        $labKom1 = Ruang::create(['kode' => 'LAB-K1', 'nama' => 'Lab Komputer 1', 'tipe' => 'lab', 'kapasitas' => 36]);
        $labKom2 = Ruang::create(['kode' => 'LAB-K2', 'nama' => 'Lab Komputer 2', 'tipe' => 'lab', 'kapasitas' => 36]);
        $labJar = Ruang::create(['kode' => 'LAB-J', 'nama' => 'Lab Jaringan', 'tipe' => 'lab', 'kapasitas' => 30]);
        $labMM = Ruang::create(['kode' => 'LAB-MM', 'nama' => 'Lab Multimedia', 'tipe' => 'lab', 'kapasitas' => 30]);

        // Mata Pelajaran - Umum
        $pai = MataPelajaran::create(['kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam', 'kelompok' => 'wajib', 'jam_per_minggu' => 3]);
        $pkn = MataPelajaran::create(['kode' => 'PKN', 'nama' => 'Pendidikan Pancasila', 'kelompok' => 'wajib', 'jam_per_minggu' => 2]);
        $bind = MataPelajaran::create(['kode' => 'BIND', 'nama' => 'Bahasa Indonesia', 'kelompok' => 'wajib', 'jam_per_minggu' => 3]);
        $bing = MataPelajaran::create(['kode' => 'BING', 'nama' => 'Bahasa Inggris', 'kelompok' => 'wajib', 'jam_per_minggu' => 3]);
        $mtk = MataPelajaran::create(['kode' => 'MTK', 'nama' => 'Matematika', 'kelompok' => 'wajib', 'jam_per_minggu' => 4]);
        $pjok = MataPelajaran::create(['kode' => 'PJOK', 'nama' => 'Pendidikan Jasmani', 'kelompok' => 'wajib', 'jam_per_minggu' => 2]);
        $sbd = MataPelajaran::create(['kode' => 'SBD', 'nama' => 'Seni Budaya', 'kelompok' => 'wajib', 'jam_per_minggu' => 2]);
        $sjr = MataPelajaran::create(['kode' => 'SJR', 'nama' => 'Sejarah Indonesia', 'kelompok' => 'wajib', 'jam_per_minggu' => 2]);

        // Mata Pelajaran - Produktif TKJ/RPL
        $dptik = MataPelajaran::create(['kode' => 'DPTIK', 'nama' => 'Dasar Program Keahlian TIK', 'kelompok' => 'peminatan', 'jam_per_minggu' => 6]);
        $sisjar = MataPelajaran::create(['kode' => 'SISJAR', 'nama' => 'Sistem Jaringan Komputer', 'kelompok' => 'peminatan', 'jam_per_minggu' => 6]);
        $tkro = MataPelajaran::create(['kode' => 'TKRO', 'nama' => 'Teknologi Komputer dan Komunikasi', 'kelompok' => 'peminatan', 'jam_per_minggu' => 4]);
        $webpro = MataPelajaran::create(['kode' => 'WEB', 'nama' => 'Pemrograman Web', 'kelompok' => 'peminatan', 'jam_per_minggu' => 6]);
        $pemdb = MataPelajaran::create(['kode' => 'PBD', 'nama' => 'Pemrograman Basis Data', 'kelompok' => 'peminatan', 'jam_per_minggu' => 4]);
        $pbo = MataPelajaran::create(['kode' => 'PBO', 'nama' => 'Pemrograman Berorientasi Objek', 'kelompok' => 'peminatan', 'jam_per_minggu' => 6]);
        
        // Mata Pelajaran - Produktif MM
        $desGraf = MataPelajaran::create(['kode' => 'DG', 'nama' => 'Desain Grafis', 'kelompok' => 'peminatan', 'jam_per_minggu' => 6]);
        $animasi = MataPelajaran::create(['kode' => 'ANI', 'nama' => 'Animasi 2D dan 3D', 'kelompok' => 'peminatan', 'jam_per_minggu' => 6]);
        $video = MataPelajaran::create(['kode' => 'VID', 'nama' => 'Pengolahan Audio Video', 'kelompok' => 'peminatan', 'jam_per_minggu' => 4]);

        // Guru
        $userGuru1 = User::create(['name' => 'Ahmad Firdaus, S.Pd', 'email' => 'ahmad.firdaus@smkkreatifdompu.sch.id', 'username' => '198501012010011001', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guru1 = Guru::create(['user_id' => $userGuru1->id, 'nip' => '198501012010011001', 'nama' => 'Ahmad Firdaus, S.Pd', 'jenis_kelamin' => 'L']);

        $userGuru2 = User::create(['name' => 'Siti Nurhaliza, S.Kom', 'email' => 'siti.nurhaliza@smkkreatifdompu.sch.id', 'username' => '198702152011012002', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guru2 = Guru::create(['user_id' => $userGuru2->id, 'nip' => '198702152011012002', 'nama' => 'Siti Nurhaliza, S.Kom', 'jenis_kelamin' => 'P']);

        $userGuru3 = User::create(['name' => 'Muhammad Rizki, S.T', 'email' => 'muhammad.rizki@smkkreatifdompu.sch.id', 'username' => '199003202012011003', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guru3 = Guru::create(['user_id' => $userGuru3->id, 'nip' => '199003202012011003', 'nama' => 'Muhammad Rizki, S.T', 'jenis_kelamin' => 'L']);

        $userGuru4 = User::create(['name' => 'Dewi Safitri, S.Pd', 'email' => 'dewi.safitri@smkkreatifdompu.sch.id', 'username' => '198805152013012004', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guru4 = Guru::create(['user_id' => $userGuru4->id, 'nip' => '198805152013012004', 'nama' => 'Dewi Safitri, S.Pd', 'jenis_kelamin' => 'P']);

        $userGuru5 = User::create(['name' => 'Hasan Abdullah, S.Ag', 'email' => 'hasan.abdullah@smkkreatifdompu.sch.id', 'username' => '197506102000011005', 'password' => Hash::make('password'), 'role' => 'guru']);
        $guru5 = Guru::create(['user_id' => $userGuru5->id, 'nip' => '197506102000011005', 'nama' => 'Hasan Abdullah, S.Ag', 'jenis_kelamin' => 'L']);

        // Assign guru ke mata pelajaran
        $mtk->guru()->attach([$guru1->id]);
        $bind->guru()->attach([$guru4->id]);
        $bing->guru()->attach([$guru4->id]);
        $pai->guru()->attach([$guru5->id]);
        $sisjar->guru()->attach([$guru2->id, $guru3->id]);
        $webpro->guru()->attach([$guru2->id]);
        $pbo->guru()->attach([$guru2->id, $guru3->id]);
        $dptik->guru()->attach([$guru3->id]);

        // Siswa X TKJ 1
        $siswaTKJ = [
            ['nis' => '24001', 'nama' => 'Aldi Pratama', 'jk' => 'L'],
            ['nis' => '24002', 'nama' => 'Bunga Citra', 'jk' => 'P'],
            ['nis' => '24003', 'nama' => 'Dimas Saputra', 'jk' => 'L'],
            ['nis' => '24004', 'nama' => 'Eka Putri', 'jk' => 'P'],
            ['nis' => '24005', 'nama' => 'Fajar Nugroho', 'jk' => 'L'],
            ['nis' => '24006', 'nama' => 'Gita Anjani', 'jk' => 'P'],
            ['nis' => '24007', 'nama' => 'Hendra Wijaya', 'jk' => 'L'],
            ['nis' => '24008', 'nama' => 'Indah Permata', 'jk' => 'P'],
            ['nis' => '24009', 'nama' => 'Joko Susilo', 'jk' => 'L'],
            ['nis' => '24010', 'nama' => 'Kartika Sari', 'jk' => 'P'],
        ];

        foreach ($siswaTKJ as $s) {
            $userSiswa = User::create([
                'name' => $s['nama'],
                'email' => strtolower(str_replace(' ', '.', $s['nama'])) . '@smkkreatifdompu.sch.id',
                'username' => $s['nis'],
                'password' => Hash::make('password'),
                'role' => 'siswa'
            ]);
            Siswa::create([
                'user_id' => $userSiswa->id,
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'jenis_kelamin' => $s['jk'],
                'kelas_id' => $kelasXTKJ1->id
            ]);
        }

        // Siswa X RPL 1
        $siswaRPL = [
            ['nis' => '24011', 'nama' => 'Lukman Hakim', 'jk' => 'L'],
            ['nis' => '24012', 'nama' => 'Maya Sari', 'jk' => 'P'],
            ['nis' => '24013', 'nama' => 'Nanda Pratiwi', 'jk' => 'P'],
            ['nis' => '24014', 'nama' => 'Oscar Ramadhan', 'jk' => 'L'],
            ['nis' => '24015', 'nama' => 'Putri Ayu', 'jk' => 'P'],
        ];

        foreach ($siswaRPL as $s) {
            $userSiswa = User::create([
                'name' => $s['nama'],
                'email' => strtolower(str_replace(' ', '.', $s['nama'])) . '@smkkreatifdompu.sch.id',
                'username' => $s['nis'],
                'password' => Hash::make('password'),
                'role' => 'siswa'
            ]);
            Siswa::create([
                'user_id' => $userSiswa->id,
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'jenis_kelamin' => $s['jk'],
                'kelas_id' => $kelasXRPL1->id
            ]);
        }

        // Jam Istirahat
        JamIstirahat::create(['nama' => 'Istirahat 1', 'setelah_jam_ke' => 3, 'durasi_menit' => 15]);
        JamIstirahat::create(['nama' => 'Istirahat 2 (Sholat)', 'setelah_jam_ke' => 6, 'durasi_menit' => 30]);

        // Jadwal X TKJ 1
        Jadwal::create(['semester_id' => $semesterGanjil->id, 'kelas_id' => $kelasXTKJ1->id, 'mata_pelajaran_id' => $pai->id, 'guru_id' => $guru5->id, 'ruang_id' => $ruang1->id, 'hari' => 'senin', 'jam_mulai' => '07:00', 'jam_selesai' => '08:30']);
        Jadwal::create(['semester_id' => $semesterGanjil->id, 'kelas_id' => $kelasXTKJ1->id, 'mata_pelajaran_id' => $mtk->id, 'guru_id' => $guru1->id, 'ruang_id' => $ruang1->id, 'hari' => 'senin', 'jam_mulai' => '08:30', 'jam_selesai' => '10:00']);
        Jadwal::create(['semester_id' => $semesterGanjil->id, 'kelas_id' => $kelasXTKJ1->id, 'mata_pelajaran_id' => $sisjar->id, 'guru_id' => $guru2->id, 'ruang_id' => $labJar->id, 'hari' => 'senin', 'jam_mulai' => '10:15', 'jam_selesai' => '12:30']);
        
        Jadwal::create(['semester_id' => $semesterGanjil->id, 'kelas_id' => $kelasXTKJ1->id, 'mata_pelajaran_id' => $bind->id, 'guru_id' => $guru4->id, 'ruang_id' => $ruang1->id, 'hari' => 'selasa', 'jam_mulai' => '07:00', 'jam_selesai' => '08:30']);
        Jadwal::create(['semester_id' => $semesterGanjil->id, 'kelas_id' => $kelasXTKJ1->id, 'mata_pelajaran_id' => $dptik->id, 'guru_id' => $guru3->id, 'ruang_id' => $labKom1->id, 'hari' => 'selasa', 'jam_mulai' => '08:30', 'jam_selesai' => '11:30']);
        
        Jadwal::create(['semester_id' => $semesterGanjil->id, 'kelas_id' => $kelasXTKJ1->id, 'mata_pelajaran_id' => $bing->id, 'guru_id' => $guru4->id, 'ruang_id' => $ruang1->id, 'hari' => 'rabu', 'jam_mulai' => '07:00', 'jam_selesai' => '08:30']);
        Jadwal::create(['semester_id' => $semesterGanjil->id, 'kelas_id' => $kelasXTKJ1->id, 'mata_pelajaran_id' => $sisjar->id, 'guru_id' => $guru3->id, 'ruang_id' => $labJar->id, 'hari' => 'rabu', 'jam_mulai' => '08:30', 'jam_selesai' => '11:30']);

        // Sample Notifikasi
        $firstSiswa = User::where('role', 'siswa')->first();
        if ($firstSiswa) {
            Notifikasi::create(['user_id' => $firstSiswa->id, 'judul' => 'Selamat Datang!', 'pesan' => 'Selamat datang di SIAKAD SMK Kreatif Dompu. Semangat belajar!', 'tipe' => 'info']);
            Notifikasi::create(['user_id' => $firstSiswa->id, 'judul' => 'Jadwal Semester Ganjil', 'pesan' => 'Jadwal pelajaran semester ganjil 2024/2025 telah tersedia.', 'tipe' => 'success']);
        }

        Notifikasi::create(['user_id' => $userGuru1->id, 'judul' => 'Selamat Datang!', 'pesan' => 'Selamat datang di SIAKAD SMK Kreatif Dompu.', 'tipe' => 'info']);
        Notifikasi::create(['user_id' => $userGuru2->id, 'judul' => 'Selamat Datang!', 'pesan' => 'Selamat datang di SIAKAD SMK Kreatif Dompu.', 'tipe' => 'info']);
    }
}
